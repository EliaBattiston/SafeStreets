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

    public function testDeleteReport(): void
    {
        global $_CONFIG;
        $DBconn = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']) or die('Connection error');
        
        //Inserting new report
        $statement = $DBconn->prepare("INSERT INTO reports (user, violation, licensePlate, street, latitude, longitude) VALUES ('ABCABCABCA000000', 1, 'AA111AA', 1, 45.4312, 9.12584)");
        $statement->execute();
        $result = $statement->get_result();

        //Getting ID
        $reportID = $DBconn->insert_id;

        //Try deleting
        Reports::deleteReport($reportID);
        $details = Reports::pastReportDetails($reportID);

        //Should be removed from the database
        $this->assertCount(0, $details);
    }

    public function testCreateReport(): void
    {
        $reportID = Reports::createReport('ABCABCABCA000000', 'AA111AA', 1, 45.4312, 9.12584, array("dummyPicture"));
        
        //Check if it exists
        $details = Reports::pastReportDetails($reportID);
        $this->assertCount(1, $details);
        $this->assertEquals($details[0]["licensePlate"], 'AA111AA');

        //Delete the record to maintain the database as it was before
        Reports::deleteReport($reportID);
    }
}

?>