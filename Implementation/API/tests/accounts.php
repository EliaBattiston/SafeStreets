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
}

?>