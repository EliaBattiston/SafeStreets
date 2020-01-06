using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Maps;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class StreetsSafetyMapPage : ContentPage
	{
		public StreetsSafetyMapPage ()
		{
			InitializeComponent ();

			CenterMap();
			LoadPins();
		}

		public async void CenterMap()
		{
			//Position position = new Position(45.478246, 9.227250);
			Position position = await MyGeolocator.GetActualPosition();
			MapSpan mapSpan = MapSpan.FromCenterAndRadius(position, Xamarin.Forms.Maps.Distance.FromKilometers(1));
			xMap.MoveToRegion(mapSpan);
		}

		public async void LoadPins()
		{
			StreetSafetyPins data = await JsonRequest.StreetSafety(App.username, App.pass);

			if(data != null && data.result == 200)
			{
				foreach(var pin in data.content)
				{
					Pin mapPin = new Pin
					{
						Position = new Position(pin.latitude, pin.longitude),
						Label = pin.address + " (" + pin.severity + ")",
						Address = pin.content,
						Type = PinType.SavedPin
					};
					xMap.Pins.Add(mapPin);
				}
			}
			else
			{
				await DisplayAlert("Information", "No information about Street Safety has been found!", "Ok");
			}
			
		}
	}
}