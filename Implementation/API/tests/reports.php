<?php
use PHPUnit\Framework\TestCase;

include_once( __DIR__ . "/config.php" );
include_once( __DIR__ . "/helpers.php" );
include_once( __DIR__ . "/../modules/reports.php" );

//Create dummy folder for the test reports' pictures
for($i=1; $i<=4; $i++)
{
    $target_dir = __DIR__ . "/../reportPictures/". $i ."/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
}

final class ReportsTest extends TestCase
{
    public function testAllReports(): void
    {
        $result = Reports::pastReports();

        $this->assertCount(4, $result);
    }

    public function testUserReports(): void
    {
        $result = Reports::userPastReports("userWithReports1");

        $this->assertCount(2, $result);
        
        foreach($result as $report)
        {
            $this->assertTrue($report["reportID"] < 3);
        }
    }
    
    public function testReportDetail(): void
    {
        $result = Reports::pastReportDetails(1);

        $this->assertNotNull($result);
        $this->assertEquals($result["reportID"], 1);
    }

    public function testNonexistentReportDetail(): void
    {
        $result = Reports::pastReportDetails(99);

        $this->assertNull($result);
    }

    public function testUserReportDetail(): void
    {
        $result = Reports::userPastReportDetails("userWithReports1", 1);

        $this->assertNotNull($result);
        $this->assertEquals($result["reportID"], 1);
    }

    public function testWrongUserReportDetail(): void
    {
        $result = Reports::userPastReportDetails("userWithReports2", 1);

        $this->assertNull($result);
    }

    public function testUserNonexistentReportDetail(): void
    {
        $result = Reports::userPastReportDetails("userWithReports1", 99);

        $this->assertNull($result);
    }

    public function testMobileWrongCredentials(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "wrongUser";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testMobileReports(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithReports1";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));
        
        $this->assertEquals($response->result, 200);
        $content = $response->content;
        $this->assertCount(2, $content);

        foreach($content as $report)
        {
            $this->assertTrue($report->reportID < 3);
        }
    }
    
    public function testMobileReportDetail(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithReports1";
        $_GET["password"] = "test";
        $_GET["reportID"] = "1";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));
        
        $this->assertEquals($response->result, 200);
        $content = $response->content;

        $this->assertNotNull($content);
        $this->assertEquals($content->reportID, 1);
    }

    public function testMobileNotOwnReportDetail(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithReports1";
        $_GET["password"] = "test";
        $_GET["reportID"] = "3";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));

        $this->assertEquals($response->result, 400);
    }

    public function testMobileNonexistentReportDetail(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithReports1";
        $_GET["password"] = "test";
        $_GET["reportID"] = "99";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));

        $this->assertEquals($response->result, 400);
    }

    public function testMobileNoReports(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithoutReports";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));

        $this->assertEquals($response->result, 200);
        $content = $response->content;

        $this->assertNotNull($content);
        $this->assertCount(0, $content);
    }

    /*public function testMobileCreateReport(): void
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        unset($_GET);
        unset($_POST);
        $_POST["username"] = "userWithReports1";
        $_POST["password"] = "test";
        $_POST["plate"] = "AA111AA";
        $_POST["violationType"] = "1";
        $_POST["latitude"] = 45.4312;
        $_POST["longitude"] = 9.12584;
        $_POST["pictures"] = "\"dummypicture\"";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));
        
        $this->assertEquals($response->result, 200);
        
        //Check if it was correctly inserted
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithReports1";
        $_GET["password"] = "test";
        $_GET["reportID"] = "6";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));

        $this->assertEquals($response->result, 200);
        $content = $response->content;

        $this->assertNotNull($content);
        $this->assertEquals($content->licensePlate, "AA111AA");
    }*/

    public function testWebWrongCredentials(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "wrongUser";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../web/reports/index.php"));

        $this->assertEquals($response->result, 401);
    }

    public function testWebUnauthorizedReports(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "userWithReports1";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../web/reports/index.php"));
        
        $this->assertEquals($response->result, 403);
    }

    public function testWebReports(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "officerUser";
        $_GET["password"] = "test";
        $response = json_decode(executePHP(__DIR__ . "/../web/reports/index.php"));
        
        $this->assertEquals($response->result, 200);
        $content = $response->content;
        $this->assertCount(4, $content);
    }

    public function testWebReportDetail(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "officerUser";
        $_GET["password"] = "test";
        $_GET["reportID"] = "1";
        $response = json_decode(executePHP(__DIR__ . "/../web/reports/index.php"));
        
        $this->assertEquals($response->result, 200);
        $content = $response->content;

        $this->assertNotNull($content);
        $this->assertEquals($content->reportID, 1);
    }

    public function testWebNonexistentReportDetail(): void
    {
        $_SERVER["REQUEST_METHOD"] = "GET";
        unset($_GET);
        unset($_POST);
        $_GET["username"] = "officerUser";
        $_GET["password"] = "test";
        $_GET["reportID"] = "99";
        $response = json_decode(executePHP(__DIR__ . "/../mobile/reports/index.php"));

        $this->assertEquals($response->result, 400);
    }
}

?>