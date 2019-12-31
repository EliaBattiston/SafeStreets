<?php
use PHPUnit\Framework\TestCase;

include_once( __DIR__ . "/config.php" );
include_once( __DIR__ . "/helpers.php" );
include_once( __DIR__ . "/../modules/accounts.php" );

final class AccountsTest extends TestCase
{
    public function testCorrectLogin(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        $_POST["username"] = "regularUser";
        $_POST["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../accounts/login/index.php"));

        $this->assertEquals($response->result, 200);
    }

    public function testWrongPassword(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        $_POST["username"] = "regularUser";
        $_POST["password"] = "wrong";
        $response = json_decode(executePHP(__DIR__ . "/../accounts/login/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testNonExistentUser(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        $_POST["username"] = "wrongUser";
        $_POST["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../accounts/login/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testCorrectUserData(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        $_POST["username"] = "regularUser";
        $_POST["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../accounts/login/index.php"));
        
        $this->assertEquals($response->result, 200);
        $content = $response->content;
        $this->assertEquals($content->fiscalCode, "ABCABCABCA000000");
        $this->assertEquals($content->firstName, "Name");
        $this->assertEquals($content->lastName, "Surname");
        $this->assertEquals($content->username, "regularUser");
        $this->assertEquals($content->suspended, false);
        $this->assertEquals($content->roleCode, 1);
        $this->assertEquals($content->roleDesc, "Regular");
    }

    public function testSuspendedUser(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        $_POST["username"] = "suspendedUser";
        $_POST["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../accounts/login/index.php"));

        $this->assertEquals($response->result, 402);  
    }

    public function testMissingParameters(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        $response = json_decode(executePHP(__DIR__ . "/../accounts/login/index.php"));

        $this->assertEquals($response->result, 404);
    }

    public function testFiscalCode(): void
    {
        $result = Accounts::userFiscalCode("regularUser");

        $this->assertEquals($result, "ABCABCABCA000000");
    }

    public function testWrongFiscalCode(): void
    {
        $result = Accounts::userFiscalCode("wrongUser");

        $this->assertNull($result);
    }

    public function testIsOfficer(): void
    {
        $result = Accounts::isOfficer("officerUser");

        $this->assertTrue($result);
    }

    public function testIsAdmin(): void
    {
        $result = Accounts::isAdministrator("administratorUser");

        $this->assertTrue($result);
    }

    public function testAdminIsOfficer(): void
    {
        $result = Accounts::isOfficer("administratorUser");

        $this->assertTrue($result);
    }

    public function testIsNotOfficer(): void
    {
        $result = Accounts::isOfficer("regularUser");

        $this->assertFalse($result);
    }

    public function testIsNotAdmin(): void
    {
        $result = Accounts::isAdministrator("officerUser");
        $this->assertFalse($result);

        $result = Accounts::isAdministrator("regularUser");
        $this->assertFalse($result);
    }

    public function testWrongOfficer(): void
    {
        $result = Accounts::isOfficer("wrongUser");

        $this->assertFalse($result);
    }

    public function testWrongAdmin(): void
    {
        $result = Accounts::isAdministrator("wrongUser");

        $this->assertFalse($result);
    }

    public function testUserDataRetrieval(): void
    {
      $result = Accounts::userList();

      $this->assertEquals(count($result), 9);
    }

    public function testUserRoleChanging(): void
    {
      $username = "regularUser";
      $this->assertTrue(Accounts::modifyUserRole($username, 4));

      $userData = Accounts::userData(Accounts::userFiscalCode($username));
      $this->assertEquals($userData['roleCode'], 4);

      $this->assertTrue(Accounts::modifyUserRole($username, 1));

      $userData = Accounts::userData(Accounts::userFiscalCode($username));
      $this->assertEquals($userData['roleCode'], 1);
    }

    public function testUserAcceptance(): void
    {
      $username = "regularUser";
      $administrator = "administratorUser";
      $this->assertTrue(Accounts::acceptUser($username, $administrator));

      $userData = Accounts::userData(Accounts::userFiscalCode($username));
      $this->assertEquals($userData['accepterAdminFiscalCode'], Accounts::userFiscalCode($administrator));
      $this->assertNotNull($userData['acceptedTimestamp']);
    }

    public function testUserSuspension(): void
    {
      $username = "regularUser";
      $this->assertTrue(Accounts::suspendUser($username));

      $userData = Accounts::userData(Accounts::userFiscalCode($username));
      $this->assertEquals($userData['suspended'], 1);
      $this->assertNotNull($userData['suspendedTimestamp']);

      $this->assertTrue(Accounts::restoreUser($username));

      $userData = Accounts::userData(Accounts::userFiscalCode($username));
      $this->assertEquals($userData['suspended'], 0);
      $this->assertNull($userData['suspendedTimestamp']);
    }

    public function testWebUsersWrongLogin(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_POST);
        unset($_GET);
        $_GET["username"] = "regularUser";
        $_GET["password"] = "wrong";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testWebUsersUnauthorized(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_POST);
        unset($_GET);
        $_GET["username"] = "regularUser";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/index.php"));

        $this->assertEquals($response->result, 403);
    }

    public function testWebUsersData(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_POST);
        unset($_GET);
        $_GET["username"] = "officerUser";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/index.php"));

        $this->assertEquals($response->result, 200);
        $this->assertCount(9, $response->content);
    }

    public function testWebSuspensionWrongLogin(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "administratorUser";
        $_POST["password"] = "wrong";
        $_POST["suspendedUser"] = "";
        $_POST["action"] = "";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/suspension/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testWebSuspensionMissingParameters(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "administratorUser";
        $_POST["password"] = "test";
        $_POST["suspendedUser"] = NULL;
        $_POST["action"] = NULL;
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/suspension/index.php"));

        $this->assertEquals($response->result, 404);
    }

    public function testWebSuspensionUnauthorized(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "officerUser";
        $_POST["password"] = "test";
        $_POST["suspendedUser"] = "regularUser";
        $_POST["action"] = "suspend";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/suspension/index.php"));

        $this->assertEquals($response->result, 403);
    }

    public function testWebSuspension(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "administratorUser";
        $_POST["password"] = "test";
        $_POST["suspendedUser"] = "regularUser";
        $_POST["action"] = "suspend";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/suspension/index.php"));
        $this->assertEquals($response->result, 200);

        $_POST["action"] = "restore";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/suspension/index.php"));
        $this->assertEquals($response->result, 200);
    }

    public function testWebAcceptanceWrongLogin(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "administratorUser";
        $_POST["password"] = "wrong";
        $_POST["acceptedUser"] = "userWithReports1";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/acceptance/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testWebAcceptanceMissingParameter(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "administratorUser";
        $_POST["password"] = "test";
        $_POST["acceptedUser"] = NULL;
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/acceptance/index.php"));

        $this->assertEquals($response->result, 404);
    }

    public function testWebAcceptanceUnauthorized(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "officerUser";
        $_POST["password"] = "test";
        $_POST["acceptedUser"] = "userWithReports1";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/acceptance/index.php"));

        $this->assertEquals($response->result, 403);
    }

    public function testWebAcceptance(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_POST);
        unset($_GET);
        $_POST["username"] = "administratorUser";
        $_POST["password"] = "test";
        $_POST["acceptedUser"] = "userWithReports1";
        $response = json_decode(executePHP(__DIR__ . "/../web/accounts/acceptance/index.php"));

        $this->assertEquals($response->result, 200);
    }
}

?>