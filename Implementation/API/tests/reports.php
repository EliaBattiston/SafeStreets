<?php
use PHPUnit\Framework\TestCase;

include_once( "config.php" );
include_once( dirname(__DIR__) . "/modules/reports.php" );

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

    public function testCreateReport(): void
    {
        $result = Reports::createReport('ABCABCABCA000000', 'AA111AA', 1, 45.4312, 9.12584, array("dummyPicture"));
        $this->assertEquals(200, $result);
        
        //Check if it exists
        $details = Reports::pastReportDetails(5);
        $this->assertNotNull($details);
        $this->assertEquals($details["licensePlate"], 'AA111AA');
    }
}

?>