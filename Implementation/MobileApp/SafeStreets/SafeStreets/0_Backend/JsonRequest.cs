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
        public static string startUrl = "http://";

        public static async Task<SimpleCallAnswer> Login(string user, string pass)
        {
            try
            {
                /*var response = await App.Client.GetAsync(startUrl + "mocky.io/v2/5df66bb33400002900e5a59b?user=" + user + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                */
                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>("{\"done\":true}");

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<SimpleCallAnswer> Registration(string email, string username, string firstName, string lastName, string fiscalCode)
        {
            try
            {
                /*var response = await App.Client.GetAsync(startUrl + "mocky.io/v2/5df66bb33400002900e5a59b?user=" + user + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                */
                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>("{\"done\":true}");

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
                SimpleCallAnswer answer = JsonConvert.DeserializeObject<SimpleCallAnswer>("{\"done\":true}");

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
                /* var response = await App.Client.GetAsync(startUrl + "mocky.io/v2/5df648df3400004f00e5a571?user=" + App.username + "&pass=" + App.pass);

                 string responseString = await response.Content.ReadAsStringAsync();

                 responseString.Replace("\\", "");

                 responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp*/

                string responseString = "{\"found\":true,\"pastReports\":[{\"typology\":\"Double Parking\",\"address\":\"Via Rossi 1, Milano\",\"dateTime\":\"12/10/2018 16:30\"}]}";

                PastReportsAnswer answer = JsonConvert.DeserializeObject<PastReportsAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }









        /**
         
             Il Cubo


             */

        public static async Task<OpportunitaRoot> GetOpportunita(string idU, string pass)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "opportunita/opportunita_ottieni_lista_o_rispondi.php?idU=" + idU + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                OpportunitaRoot off = JsonConvert.DeserializeObject<OpportunitaRoot>(responseString);
                
                return off;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<ModuliRoot> GetModuliPrenotaLezioni(string idU, string pass)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "prenota_lezioni/moduli_ottieni_lista.php?idU=" + idU + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                ModuliRoot mod = JsonConvert.DeserializeObject<ModuliRoot>(responseString);

                return mod;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<bool> SegnalaRinnovoModuloPrenotaLezioni(string idU, string idF)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "prenota_lezioni/modulo_segnala_rinnovo.php?idU=" + idU + "&idF=" + idF);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                bool done = JsonConvert.DeserializeObject<bool>(responseString);

                return done;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return false;
            }
        }

        public static async Task<DatiPerCompilaModulo> GetInfoPerCompilazioneModulo(string idU, string pass, string idP)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "prenota_lezioni/modulo_info_per_compilazione.php?idU=" + idU + "&pass=" + pass + "&idP=" + idP);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                DatiPerCompilaModulo compMod = JsonConvert.DeserializeObject<DatiPerCompilaModulo>(responseString);

                return compMod;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<RispostaInserisciModulo> InserisciNuovoModulo(string idU, string pass, string dataScelta, string oraInizio, string oreDaSvolgere, DatiPerCompilaModulo compilaModuliToShow)
        {
            try
            {
                //Debug.WriteLine("IDU: " + App.idU);
                var values = new Dictionary<string, string>
                    {
                       { "giorno", dataScelta },
                       { "orain", oraInizio },
                       { "ore", oreDaSvolgere },
                       { "idU", idU},
                       { "pass", pass},
                       { "nome", compilaModuliToShow.nome },
                       { "cognome", compilaModuliToShow.cognome },
                       { "da", compilaModuliToShow.nome_famiglia },
                       { "idP", compilaModuliToShow.idP }
                    };

                var content = new FormUrlEncodedContent(values);

                var response = await App.Client.PostAsync(startUrl + "prenota_lezioni/modulo_inserimento.php", content);

                string responseString = await response.Content.ReadAsStringAsync();

                RispostaInserisciModulo answer = JsonConvert.DeserializeObject<RispostaInserisciModulo>(responseString);
                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<RootElementiAreaPrenotazioni> RichiestaDatiConfermaModificaLezioni(string idU, string pass)
        {
            try
            {
                var values = new Dictionary<string, string>
                    {
                       { "idU", idU },
                       { "pass", pass}
                    };

                var content = new FormUrlEncodedContent(values);

                Debug.WriteLine(content.ToString());

                var response = await App.Client.PostAsync(startUrl + "conferma_modifica_lezioni/lezioni_conferma_modifica_lista.php", content);

                string responseString = await response.Content.ReadAsStringAsync();

                RootElementiAreaPrenotazioni answer = JsonConvert.DeserializeObject<RootElementiAreaPrenotazioni>(responseString); ;
                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<Boolean> LezioneModificaStatoNotifica(string id)
        {
            try
            {
                var values = new Dictionary<string, string>
                    {
                       { "id", id }
                    };

                var content = new FormUrlEncodedContent(values);

                Debug.WriteLine(content.ToString());

                var response = await App.Client.PostAsync(startUrl + "conferma_modifica_lezioni/lezioni_notifica.php", content);

                string responseString = await response.Content.ReadAsStringAsync();

                return (responseString=="0" || responseString == "1")?true:false;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return false;
            }
        }

        public static async Task<RispostaModLezione> LezioneModifica(string idU, string pass, string dataScelta, string oraInizio, string oreDaSvolgere, string idM)
        {
            try
            {
                var values = new Dictionary<string, string>
                    {
                       { "idU", idU },
                       { "pass", pass},
                       { "giorno", dataScelta },
                       { "orain", oraInizio },
                       { "ore", oreDaSvolgere },
                       { "idM" , idM}
                    };

                var content = new FormUrlEncodedContent(values);

                Debug.WriteLine(content.ToString());

                var response = await App.Client.PostAsync(startUrl + "conferma_modifica_lezioni/lezione_modifica.php", content);

                string responseString = await response.Content.ReadAsStringAsync();

                RispostaModLezione answer = JsonConvert.DeserializeObject<RispostaModLezione>(responseString); ;
                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<RispostaConfermaLezione> LezioneConferma(string idU, string pass, string idM, string materia, string argomento)
        {
            try
            {
                var values = new Dictionary<string, string>
                    {
                       { "idU", idU},
                       { "pass", pass},
                       { "idM" , idM},
                       { "materia" , materia},
                       { "argomento" , argomento}
                    };

                var content = new FormUrlEncodedContent(values);

                //Debug.WriteLine(content.ToString());

                var response = await App.Client.PostAsync(startUrl + "conferma_modifica_lezioni/lezione_conferma.php", content);

                string responseString = await response.Content.ReadAsStringAsync();

                RispostaConfermaLezione answer = JsonConvert.DeserializeObject<RispostaConfermaLezione>(responseString); ;
                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<RootGiorniDisponibilita> RichiestaDisponibilitaCollaboratore(string idU, string pass, string idP)
        {
            try
            {
                var values = new Dictionary<string, string>
                    {
                       { "idU", idU},
                       { "pass", pass},
                       { "idP" , idP}
                    };

                var content = new FormUrlEncodedContent(values);
                
                var response = await App.Client.PostAsync(startUrl + "disponibilita_collaboratore/disponibilita_lista_richieste.php", content);

                string responseString = await response.Content.ReadAsStringAsync();

                RootGiorniDisponibilita answer = JsonConvert.DeserializeObject<RootGiorniDisponibilita>(responseString);
                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine("Errore richiesta modulo" + ex);
                return null;
            }
        }

        public static async Task<GoogleMapsApiAnswer> GetDatiGoogleMaps(string url)
        {
            try
            {
                var response = await App.Client.GetAsync(url);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                GoogleMapsApiAnswer answer = JsonConvert.DeserializeObject<GoogleMapsApiAnswer>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<List<FAQStructure>> GetFAQ()//GET
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "faq/faq_ottieni_lista.php");

                string responseString = await response.Content.ReadAsStringAsync();

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                List<FAQStructure> answer = JsonConvert.DeserializeObject<List<FAQStructure>>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        /**
         * Attenzione: non pulisce le stringhe coi link in risposta
         */
        public static async Task<string[]> GetLoSapevi()//GET
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "lo_sapevi.php");

                string responseString = await response.Content.ReadAsStringAsync();

                string[] loSapeviAnswer = JsonConvert.DeserializeObject<string[]>(responseString);

                return loSapeviAnswer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<List<Rendicontazione>> GetRendicontazioni(string idU, string pass)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "rendicontazioni/rendicontazioni.php?idU=" + idU + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                List<Rendicontazione> rend = JsonConvert.DeserializeObject<List<Rendicontazione>>(responseString);

                return rend;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<RendicontazioneFirma> FirmaRendicontazione(string idU, string pass, string idCedola)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "rendicontazioni/rendicontazioni_firma_digitale.php?idU=" + idU + "&pass=" + pass + "&idC=" + idCedola);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                RendicontazioneFirma rendFirma = JsonConvert.DeserializeObject<RendicontazioneFirma>(responseString);

                return rendFirma;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        //public static async Task<bool> UploadFirmaUtente() -> fatto tutto nel codice della pagina di upload

        public static async Task<ProfiloUtente> GetProfiloUtente(string idU, string pass)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "profilo_utente.php?idU=" + idU + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                ProfiloUtente answer = JsonConvert.DeserializeObject<ProfiloUtente>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        //achievements
        public static async Task<List<RootAchievement>> GetAchievements(string idU, string pass)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "achievements/achievements.php?idU=" + idU + "&pass=" + pass);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                List<RootAchievement> answer = JsonConvert.DeserializeObject<List<RootAchievement>>(responseString);

                return answer;
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                return null;
            }
        }

        public static async Task<PremioAchievement> RichiediPremioAchievement(string idU, string pass, string idAchievement)
        {
            try
            {
                var response = await App.Client.GetAsync(startUrl + "achievements/achievements.php?idU=" + idU + "&pass=" + pass + "&idAchievement=" + idAchievement);

                string responseString = await response.Content.ReadAsStringAsync();

                responseString.Replace("\\", "");

                responseString = System.Net.WebUtility.HtmlDecode(responseString);//Decodificare cose come &nbsp

                PremioAchievement answer = JsonConvert.DeserializeObject<PremioAchievement>(responseString);

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
                return default (T);
            }
        }
    }
}
