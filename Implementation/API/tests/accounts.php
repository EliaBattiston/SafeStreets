<?php
use PHPUnit\Framework\TestCase;

include_once( "config.php" );
include_once( dirname(__DIR__) . "/modules/accounts.php" );

final class AccountsTest extends TestCase
{
    public function testLogin(): void
    {
        $result = Accounts::login("regularUser", "test");

        $this->assertNotNull($result);
    }

    public function testWrongPassword(): void
    {
        $result = Accounts::login("regularUser", "wrong");

        $this->assertNull($result);
    }

    public function testNonExistentUser(): void
    {
        $result = Accounts::login("wrongUser", "test");

        $this->assertNull($result);
    }

    public function testCorrectUserData(): void
    {
        $result = Accounts::login("regularUser", "test");

        $this->assertEquals($result["fiscalCode"], "ABCABCABCA000000");
        $this->assertEquals($result["firstName"], "Name");
        $this->assertEquals($result["lastName"], "Surname");
        $this->assertEquals($result["username"], "regularUser");
        $this->assertEquals($result["suspended"], false);
        $this->assertEquals($result["roleCode"], 1);
        $this->assertEquals($result["roleDesc"], "Regular");
    }

    public function testSuspendedUser(): void
    {
        $result = Accounts::login("suspendedUser", "test");

        $this->assertEquals($result["suspended"], true);        
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