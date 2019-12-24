using Xamarin.Essentials;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Newtonsoft.Json;
using System.Diagnostics;

namespace SafeStreets
{
    public class MyGeolocator
    {
        public static async Task<String> GetLatLngAsString()
        {
            try
            {
                var request = new GeolocationRequest(GeolocationAccuracy.Medium);
                var location = await Geolocation.GetLocationAsync(request);

                if (location != null)
                {
                    Console.WriteLine($"Latitude: {location.Latitude}, Longitude: {location.Longitude}, Altitude: {location.Altitude}");
                    return "{\"lat\":" + location.Latitude + ", \"lng\":"+ location.Longitude + "}";
                }
            }
            catch (FeatureNotSupportedException ex)
            {
                Debug.WriteLine(ex);
                // Handle not supported on device exception
            }
            catch (FeatureNotEnabledException ex)
            {
                Debug.WriteLine(ex);
                // Handle not enabled on device exception
            }
            catch (PermissionException ex)
            {
                Debug.WriteLine(ex);
                // Handle permission exception
            }
            catch (Exception ex)
            {
                Debug.WriteLine(ex);
                // Unable to get location
            }

            return null;
        }


        /*
        public string googleMapsApiKey = "AIzaSyDCiOfOuRs9zk5oeWCmtUDBgVIiQIKwpCU";
        public bool IsGPSEnabled { get; set; }
        public bool IsStaticPosizionEnabled { get; set; }
        public string nomeCittaDaUser;
        private bool datiAffidabili;
        public string nomeCitta { get; set; }
        public string accurancy;
        public string nazione;

        public bool getDatiAffidabili()
        {
            return datiAffidabili;
        }

        /*Torno -1 se non è attivato il GPS del telefono, 0 se eccezione, 1 se ok
        public async Task<int> updateGpsPosition()
        {
            if (IsGPSEnabled)
            {
                try
                {
                    var locator = CrossGeolocator.Current;
                    locator.DesiredAccuracy = 50;

                    if (!locator.IsGeolocationEnabled)
                    {
                        datiAffidabili = false;
                        return -1;
                    }

                    var position = await locator.GetPositionAsync(TimeSpan.FromSeconds(6));
                    //string pos = "Position Status: " + position.Timestamp + "Position Latitude: {0}" + position.Latitude + "Position Longitude: {0}" + position.Longitude;

                    try
                    {
                        var address = await locator.GetAddressesForPositionAsync(position, "RJHqIE53Onrqons5CNOx~FrDr3XhjDTyEXEjng-CRoA~Aj69MhNManYUKxo6QcwZ0wmXBtyva0zwuHB04rFYAPf7qqGJ5cHb03RCDw1jIW8l");
                        var a = address.FirstOrDefault();
                        nomeCitta = a.Locality;
                        nazione = a.CountryCode;
                        accurancy = (position.Accuracy * 4).ToString("n1");
                        datiAffidabili = true;
                        return 1;
                    }
                    catch (Exception ex)
                    {
                        datiAffidabili = false;//await DisplayAlert("Errore", "Errore nella ricerca del comune:\n" + ex.Message, "Ok");
                    }

                    //string detailedInfo = $"Address: Thoroughfare = {a.Thoroughfare}\nLocality = {a.Locality}\nCountryCode = {a.CountryCode}\nCountryName = {a.CountryName}\nPostalCode = {a.PostalCode}\nSubLocality = {a.SubLocality}\nSubThoroughfare = {a.SubThoroughfare}";

                }
                catch (Exception ex)
                {
                    datiAffidabili = false;//await DisplayAlert("Errore", "Errore nella ricerca della posizione:\n" + ex.Message, "Ok");
                }
            }
            return 0;
        }

        public async Task<bool> getDistances(List<Opportunita> offerte)
        {
            if (IsGPSEnabled || IsStaticPosizionEnabled)
            {
                try
                {
                    List<string> nomiCitta = new List<string>();
                    string destinazioni = "";//ES: "San+Francisco|Victoria+BC";
                    string url;

                    foreach (Opportunita x in offerte)
                    {
                        if (nomiCitta.LastIndexOf(x.citta) == -1)
                            nomiCitta.Add(x.citta);
                    }
                    foreach (string x in nomiCitta)
                        if(x!=null)
                            destinazioni += x.Replace(" ", "+") + "+IT|";  //Cambio gli spazi nei nomi citta con dei + come da API Google
                    destinazioni = destinazioni.Remove(destinazioni.Length - 1);//elimino l'ultimo pipe '|'

                    if (IsGPSEnabled && datiAffidabili)
                        url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" + nomeCitta + "+IT&destinations=" + destinazioni + "&key=" + googleMapsApiKey;
                    else
                        url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" + nomeCittaDaUser.Replace(" ", "+") + "+IT&destinations=" + destinazioni + "&key=" + googleMapsApiKey;

                    GoogleMapsApiAnswer googleAnswer = await JsonRequest.GetDatiGoogleMaps(url);

                    //int dist = googleAnswer.rows[0].elements[0].distance.value;
                    foreach (Opportunita x in offerte)
                    //for(int i=0; i<offerte.Count; i++)
                    {
                        int index;
                        //Opportunita x = offerte[i];
                        try {
                            index = nomiCitta.IndexOf(x.citta);
                            x.distanzaMetri = googleAnswer.rows[0].elements[index].distance.value;
                            x.distanzaKm = ((float)x.distanzaMetri / 1000).ToString("n1") + " Km";
                        }catch(Exception ex)
                        {
                            x.distanzaMetri = 10000; //Metto quelli non trovati oltre i 10km
                            x.distanzaKm = "Località non trovata";
                        }

                        //int index = nomiCitta.IndexOf(offerte[i].citta);
                        //offerte[i].distanzaMetri = googleAnswer.rows[0].elements[index].distance.value;
                        //offerte[i].distanzaKm = ((float)offerte[i].distanzaMetri / 1000).ToString("n1") + " Km";
                    }
                }
                catch (Exception ex)
                {
                    return false;
                }
                return true;
            }
            return false;
        }*/
    }
}