using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using System.Net.Http;
using Newtonsoft.Json;
using System.Diagnostics;

namespace SafeStreets
{
    public class JsonRequest
    {
        public static string startUrl = "https://safestreets.altervista.org/api";

        public static async Task<SimpleCallAnswer> Login(string user, string pass)
        {
            try
            {
                var values = new Dictionary<string, string>
                    {
                       { "username", user },
                       { "password", pass }
                    };

                var content = new FormUrlEncodedContent(values);

                var response = await App.Client.PostAsync(startUrl + "/accounts/login/", content);

                string responseString = await response.Content.ReadAsStringAsync();

                /*
                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                */
                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>(responseString);
                //SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>("{\"result\":200, \"otherstuffnocare\": 320}");

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<SimpleCallAnswer> Registration(string email, string username, string firstName, string lastName, string fiscalCode, string password, string documentPhoto)
        {
            try
            {
                var values = "username=" + username + "&password=" + password + "&firstName=" + firstName + "&lastName=" + lastName + "&email=" + email +
                       "&fiscalCode=" + fiscalCode + "&documentPhoto=\"" + documentPhoto + "\"";

                var content = new StringContent(values, null, "application/x-www-form-urlencoded");

                var response = await App.Client.PostAsync(startUrl + "/accounts/signup/", content);

                string responseString = await response.Content.ReadAsStringAsync();

                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<SimpleCallAnswer> RestoreCredentials(string user)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "/accounts/restorePassword/?username=" + user);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<SimpleCallAnswer> ChangePassword(string user, string oldPass, string newPass)
        {
            try
            {
                var values = "username=" + user + "&password=" + oldPass + "&newPassword=" + newPass;
                var content = new StringContent(values, null, "application/x-www-form-urlencoded");

                var response = await App.Client.PostAsync(startUrl + "/accounts/restorePassword/", content);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<SimpleCallAnswer> SendNewReport(string username, string password, string plate, int violationType, double latitude, double longitude, List<String> imagesBase64)
        {
            try
            {
                string pictures = "[\"" + string.Join("\",\"", imagesBase64) + "\"]";
                var values = "username=" + username + "&password=" + password + "&plate=" + plate + "&violationType=" + violationType + "&latitude=" + latitude +
                       "&longitude=" + longitude + "&pictures=" + pictures;

                var content = new StringContent(values, null, "application/x-www-form-urlencoded");

                var response = await App.Client.PostAsync(startUrl + "/mobile/reports/", content);

                string responseString = await response.Content.ReadAsStringAsync();

                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<PastReportsAnswer> LoadOldReports()
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "/mobile/reports/?username=" + App.username + "&password=" + App.pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                PastReportsAnswer answer = JsonConvert.DeserializeObject<PastReportsAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }


        public static async Task<StreetSafetyPins> StreetSafety(string user, string pass)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "/mobile/streetSafety/?username=" + App.username + "&password=" + App.pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                StreetSafetyPins answer = JsonConvert.DeserializeObject<StreetSafetyPins>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }
    }
}
