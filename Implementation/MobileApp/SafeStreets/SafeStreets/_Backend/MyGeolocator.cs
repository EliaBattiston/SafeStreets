using Xamarin.Essentials;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Newtonsoft.Json;
using System.Diagnostics;
using Xamarin.Forms.Maps;

namespace SafeStreets
{
    public class MyGeolocator
    {
        public static async Task<Position> GetActualPosition()
        {
            try
            {
                var request = new GeolocationRequest(GeolocationAccuracy.Medium);
                var location = await Geolocation.GetLocationAsync(request);

                if (location != null)
                {
                    Console.WriteLine($"Latitude: {location.Latitude}, Longitude: {location.Longitude}, Altitude: {location.Altitude}");

                    return new Position(location.Latitude, location.Longitude);
                }
            }
            catch (FeatureNotSupportedException ex)
            {
                Debug.WriteLine("1");
                Debug.WriteLine(ex);
                // Handle not supported on device exception
            }
            catch (FeatureNotEnabledException ex)
            {
                Debug.WriteLine("2");
                Debug.WriteLine(ex);
                // Handle not enabled on device exception
            }
            catch (PermissionException ex)
            {
                Debug.WriteLine("3");
                Debug.WriteLine(ex);
                // Handle permission exception
            }
            catch (Exception ex)
            {
                Debug.WriteLine("4");
                Debug.WriteLine(ex);
                // Unable to get location
            }

            return new Position(0,0);
        }

        public static async Task<String> GetPlaceName(Position location)
        {
            if (location.Latitude != 0 && location.Longitude != 0)
            {
                var placemarks = await Geocoding.GetPlacemarksAsync(location.Latitude, location.Longitude);

                var placemark = placemarks?.FirstOrDefault();
                if (placemark != null)
                {
                    var geocodeAddress = placemark.Thoroughfare + " " + placemark.SubThoroughfare + ", " + placemark.Locality;
                    //$"AdminArea:       {placemark.AdminArea}\n" +
                    //$"CountryCode:     {placemark.CountryCode}\n" +
                    //$"CountryName:     {placemark.CountryName}\n" +
                    //$"FeatureName:     {placemark.FeatureName}\n" +
                    //$"Locality:        {placemark.Locality}\n" +
                    //$"PostalCode:      {placemark.PostalCode}\n" +
                    //$"SubAdminArea:    {placemark.SubAdminArea}\n" +
                    //$"SubLocality:     {placemark.SubLocality}\n" +
                    //$"SubThoroughfare: {placemark.SubThoroughfare}\n" +
                    //$"Thoroughfare:    {placemark.Thoroughfare}\n";

                    Console.WriteLine(geocodeAddress);

                    return geocodeAddress;
                }
            }
            
            return "Place not found";
        }

    }
}