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

        public static async Task<SimpleCallAnswer> RestoreCredentials(string email)
        {
            try
            {
                /*var response = await App.Client.GetAsync(startUrl + "mocky.io/v2/5df66bb33400002900e5a59b?user=" + user + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                */
                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>("{\"result\":200}");

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

                //string responseString = "{\"found\":true,\"pastReports\":[{\"typology\":\"Double Parking\",\"address\":\"Via Rossi 1, Milano\",\"dateTime\":\"12/10/2018 16:30\"}]}";
                //string responseString = "{ \"result\":200,\"content\": [{ \"username\":\"reporterUsername\", \"latitude\":\"45.08\", \"longitude\":\"8.04\",\"reportID\":1,\"timestamp\":\"2000-01-01 00:00:01\",\"address\":\"address\", \"licensePlate\":\"AA000AA\", \"violation\":\"violation\", \"notes\":\"notes\", \"pictures\": [\"https://upload.wikimedia.org/wikipedia/commons/c/c6/Georg_Carabelli.jpg\", \"https://upload.wikimedia.org/wikipedia/commons/c/c6/Georg_Carabelli.jpg\"] } ]}";

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
                //StreetSafetyPins answer = JsonConvert.DeserializeObject<StreetSafetyPins>("{ \"result\":200,  \"content\": [{\"address\":\"address\",  \"latitude\": 45.000000,\"longitude\": 8.000000,\"severity\":\"High\",\"content\":\"violationDetails\" }, {\"address\":\"address2\",  \"latitude\": 45.002000,\"longitude\": 8.002000,\"severity\":\"Low\",\"content\":\"violationDetails\" } ]}");

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }




        /**
         * Esempio richiesta SINCRONA
         */
        /*public static string[] GetLoSapevi()//GET
        {
            try
            {
                var response = App.Client.GetAsync(startUrl + "lo_sapevi.php").Result;

                string responseString = response.Content.ReadAsStringAsync().Result;

                string[] loSapeviAnswer = JsonConvert.DeserializeObject<string[]>(responseString);

                return loSapeviAnswer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }*/

        /**
         * Attenzione: non pulisce le stringhe coi link in risposta
         */
        public static async Task<string> CallWebPage(string url)//GET
        {
            try
            {
                var response = await App.Client.GetAsync(url);

                string responseString = await response.Content.ReadAsStringAsync();

                return responseString;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<T> CallWebPagePost<T>(string url, List<KeyValuePair<string, string>> postValues)//POST
        {
            try
            {
                var content = new FormUrlEncodedContent(postValues);

                Debug.WriteLine(content.ToString());

                var response = await App.Client.PostAsync(url, content);

                string responseString = await response.Content.ReadAsStringAsync();

                T answer = JsonConvert.DeserializeObject<T>(responseString); ;
                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return default(T);
            }
        }
    }
}
