<?php
use PHPUnit\Framework\TestCase;

include_once( "config.php" );
include_once( dirname(__DIR__) . "/modules/reports.php" );

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

        $this->assertCount(1, $result);
        
        foreach($result as $report)
        {
            $this->assertEquals($report["username"], "userWithReports1");
            $this->assertEquals($report["reportID"], 1);
        }
    }

    public function testNonexistentReportDetail(): void
    {
        $result = Reports::pastReportDetails(99);

        $this->assertCount(0, $result);
    }

    public function testUserReportDetail(): void
    {
        $result = Reports::userPastReportDetails("userWithReports1", 1);

        $this->assertCount(1, $result);
        
        foreach($result as $report)
        {
            $this->assertEquals($report["username"], "userWithReports1");
            $this->assertEquals($report["reportID"], 1);
            
        }
    }

    public function testWrongUserReportDetail(): void
    {
        $result = Reports::userPastReportDetails("userWithReports2", 1);

        $this->assertCount(0, $result);
    }

    public function testUserNonexistentReportDetail(): void
    {
        $result = Reports::userPastReportDetails("userWithReports1", 99);

        $this->assertCount(0, $result);
    }
}

?>