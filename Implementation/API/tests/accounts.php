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
}

?>