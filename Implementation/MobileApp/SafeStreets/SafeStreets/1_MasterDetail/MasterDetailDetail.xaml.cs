using System;
using System.Diagnostics;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
    //Esempio di pagina richiamata

    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class MasterDetailDetail : ContentPage
    {
        public MasterDetailDetail()
        {
            InitializeComponent();
        }

        protected override void OnAppearing()
        {
            base.OnAppearing();
        }

        //async void LoadSuggerimenti()
        //{
        //    loSapeviStrings = await JsonRequest.GetLoSapevi();
            
        //    loadLoSapeviText();

        //    var tapGestureRecognizer = new TapGestureRecognizer();
        //    tapGestureRecognizer.Tapped += (s, e) => {
        //        loadLoSapeviText();
        //    };
        //    xLoSapeviStackLayout.GestureRecognizers.Add(tapGestureRecognizer);
        //}

        

        //async void LoadDisponibilita()
        //{
        //    disponibilitaToShow = await JsonRequest.RichiestaDisponibilitaCollaboratore(App.username, App.pass, "");

        //    if (disponibilitaToShow != null)
        //    {
        //        disponibilitaCaricate = true;

        //        if (!disponibilitaToShow.error)
        //            xDisponibilitaButton.BackgroundColor = Color.FromHex("#EE6352"); /*OLD: #d54d49*/
        //    }
        //    else
        //        await DisplayAlert("Attenzione", "Sembra non sia attiva la tua connessione ad internet. La maggior parte delle funzionalità dell'app non funzionerà.", "OK");

        //    Debug.WriteLine("Disp finito");
        //}

        async void OnClickGeolocation(object sender, EventArgs e)
        {
            string latlng = await MyGeolocator.GetLatLngAsString();

            if(latlng != null)
            {
                xLocationLabel.Text = latlng;
            }
            else
            {
                xLocationLabel.Text = "Couldn't find position";
            }
        }
    }
}