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

			Position position = new Position(45.478246, 9.227250);
			MapSpan mapSpan = MapSpan.FromCenterAndRadius(position, Xamarin.Forms.Maps.Distance.FromKilometers(0.5));
			xMap.MoveToRegion(mapSpan);

			Pin wharfPin = new Pin
			{
				Position = new Position(45.478247, 9.227251),
				Label = "Titolo",
				Address = "StoriellaBellaBella",
				Type = PinType.SavedPin
			};

			Pin wharfPin2 = new Pin
			{
				Position = new Position(45.478245, 9.227251),
				Label = "Titolo222",
				Address = "StoriellaBellaBella",
				Type = PinType.SavedPin
			};
			xMap.Pins.Add(wharfPin);
			xMap.Pins.Add(wharfPin2);
		}
	}
}