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
	public partial class PastReportDetailPage : ContentPage
	{
		public PastReportDetailPage (PastReport report)
		{
			InitializeComponent ();

            xTypologyLabel.Text = report.violation;
            xAddressLabel.Text = report.address;
            xDateTimeLabel.Text = report.timestamp;
            xLicensePlateLabel.Text = report.licensePlate;
            xNotesLabel.Text = report.notes;

			if (report.pictures.Count > 0)
				xCarouselView.ItemsSource = report.pictures;
			else
				xNoPicAvailable.IsVisible = true;

			Position position = new Position(report.latitude, report.longitude);
			MapSpan mapSpan = MapSpan.FromCenterAndRadius(position, Xamarin.Forms.Maps.Distance.FromKilometers(0.5));
			xDetailReportMap.MoveToRegion(mapSpan);

			Pin reportPos = new Pin
			{
				Position = position,
				Label = "Titolo",
				Address = "StoriellaBellaBella",
				Type = PinType.SavedPin
			};
			xDetailReportMap.Pins.Add(reportPos);
		}

        //tolbar closeModal button handler
        async void OnCloseModalClicked(object sender, System.EventArgs e)
        {
            await Navigation.PopModalAsync();
        }

    }
}