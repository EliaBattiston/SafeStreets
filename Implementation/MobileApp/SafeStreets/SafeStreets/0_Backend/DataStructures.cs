using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SafeStreets
{
    public class Utils
    {
        public static bool HasText(string s)
        {
            return s != string.Empty && s != null; 
        }
    }
    public class SimpleCallAnswer
    {
        public int result { get; set; }
        public string message { get; set; }
    }

    //Past reports start
    public class PastReport
    {
        public string username { get; set; }
        public int reportID { get; set; }
        public string timestamp { get; set; }
        public string address { get; set; }
        public double latitude { get; set; }
        public double longitude { get; set; }
        public string licensePlate { get; set; }
        public string violation { get; set; }
        public string notes { get; set; }
        public List<string> pictures { get; set; }
    }

    public class PastReportsAnswer
    {
        public bool found { get; set; }
        public List<PastReport> pastReports { get; set; }

        public int result { get; set; }
        public List<PastReport> content { get; set; }
    }
    //Past reports end

    //StreetSafety
    public class StreetSafetyPinDetail
    {
        public string address { get; set; }
        public double latitude { get; set; }
        public double longitude { get; set; }
        public string severity { get; set; }
        public string content { get; set; }
    }

    public class StreetSafetyPins
    {
        public int result { get; set; }
        public List<StreetSafetyPinDetail> content { get; set; }
    }

}
