using Plugin.Media;
using System;
using System.Collections.Generic;
using System.Diagnostics;

using Xamarin.Forms;
using Xamarin.Forms.Maps;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
    public class ReportInfo
    {
        public string text { get; set; }
        public int code { get; set; }

        public ReportInfo(string text, int code)
        {
            this.text = text;
            this.code = code;
        }
    }

    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class MasterDetailDetail : ContentPage
    {
        private List<String> imagesBase64;
        private List<ImageSource> images;
        private double latitude = double.NaN;
        private double longitude = double.NaN;

        public MasterDetailDetail()
        {
            InitializeComponent();

            List<ReportInfo> rf = new List<ReportInfo>();

            rf.Add(new ReportInfo("Other", 1));
            rf.Add(new ReportInfo("Double parking", 2));
            rf.Add(new ReportInfo("Parking in no parking area", 3));
            rf.Add(new ReportInfo("Traffic obstruction", 4));
            rf.Add(new ReportInfo("Parking disk over time", 5));
            rf.Add(new ReportInfo("Parking in paid area without receipt", 6));
            rf.Add(new ReportInfo("Abandoned car", 7));
            rf.Add(new ReportInfo("Left rear view mirror damaged or missing", 8));
            rf.Add(new ReportInfo("Parking on sidewalk", 9));
            rf.Add(new ReportInfo("Parking on bicycle or walkable lane", 10));

            xReportInformationPicker.ItemsSource = rf;

            imagesBase64 = new List<string>();
            images = new List<ImageSource>();
        }

        protected override void OnAppearing()
        {
            base.OnAppearing();
        }


        async void OnClickGeolocation(object sender, EventArgs e)
        {
            Position locality = await MyGeolocator.GetActualPosition();
            latitude = locality.Latitude;
            longitude = locality.Longitude;

            string placeName = await MyGeolocator.GetPlaceName(locality);

            if(placeName != null)
            {
                xLocationLabel.Text = placeName;
            }
            else
            {
                xLocationLabel.Text = "Couldn't find position";
            }
        }

        private async void CameraButton_Clicked(object sender, EventArgs e)
        {
            await CrossMedia.Current.Initialize();

            if (!CrossMedia.Current.IsCameraAvailable || !CrossMedia.Current.IsTakePhotoSupported)
            {
                await DisplayAlert("No Camera", "No camera available.", "OK");
                return;
            }

            var photo = await CrossMedia.Current.TakePhotoAsync(new Plugin.Media.Abstractions.StoreCameraMediaOptions()
            {
                Directory = "SafeStreets",
            });

            if (photo != null)
            {
                images.Add(photo.Path);
                xCarouselViewNewReport.ItemsSource = null;
                xCarouselViewNewReport.ItemsSource = images;

                byte[] b = System.IO.File.ReadAllBytes(photo.Path);
                imagesBase64.Add(Convert.ToBase64String(b));

                xCarouselViewNewReport.IsVisible = true;
            }
        }

        private async void OnClickSendReport(object sender, EventArgs e)
        {
            ReportInfo rInfo = (ReportInfo)xReportInformationPicker.SelectedItem;
            string plate = xPlateEntry.Text;
            string note = xNotesEntry.Text;

            if (rInfo != null && Utils.HasText(plate) && Utils.HasText(note))
            {
                if(latitude != double.NaN && longitude != double.NaN)
                {
                    if(imagesBase64.Count > 0)
                    {
                        var answer = await JsonRequest.SendNewReport(App.username, App.pass, plate, rInfo.code, latitude, longitude, imagesBase64);

                        if (answer != null)
                        {
                            if(answer.result == 200)
                            {
                                await DisplayAlert("Sent!", "Your report has been sent!", "Ok");
                            }
                            else
                            {
                                await DisplayAlert("Error " + answer.result, answer.message, "Ok");
                            }
                        }
                        else
                        {
                            await DisplayAlert("Error", "Error contacting the server", "Ok");
                        }
                    }
                    else
                    {
                        await DisplayAlert("Attention!", "Insert at least one image of the accident!", "Ok");
                    }
                }
                else
                {
                    await DisplayAlert("Attention!", "Request your position before sending the report!", "Ok");
                }
            }
            else
            {
                await DisplayAlert("Attention!", "Insert the report information!", "Ok");
            }
        }
    }
}