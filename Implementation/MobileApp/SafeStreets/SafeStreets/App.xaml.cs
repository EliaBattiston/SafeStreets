using System;
using System.Net.Http;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using Xamarin.Essentials;
using System.Net;

[assembly: XamlCompilation(XamlCompilationOptions.Compile)]
namespace SafeStreets
{
    public partial class App : Application
    {
        public static string username { get; set; }
        public static string pass { get; set; }
        public static bool IsUserLoggedIn { get; set; }

        public static string startUrl = "http://app.il-cubo.it/";
        public static HttpClient Client { get; set; }

        public static Page portableDetail { get; set; }
        private static Application MyApp { get; set; } //è l'oggetto che crea l'app, mi serve il reference per cambiare la MainPage nella gestione del login

        public App()
        {
            InitializeComponent();

            MyApp = this;

            ServicePointManager.ServerCertificateValidationCallback += (sender, cert, chain, sslPolicyErrors) => true;
            Client = new HttpClient();

            try
            {
                username = SecureStorage.GetAsync("username").Result;
                pass = SecureStorage.GetAsync("pass").Result;

                if(username == null || pass == null)
                    GoToLoginPage();
                else
                    LoginDone();
            }
            catch (Exception ex)
            {
                // Possible that device doesn't support secure storage on device.
                GoToLoginPage();
            }
            
        }

        public static void GoToLoginPage()
        {
            portableDetail = null;
            var page = new LoginPage();
            var nav = new NavigationPage(page);
            MyApp.MainPage = nav; //{ BarBackgroundColor = Color.FromHex("#1C77C3"), BarTextColor = Color.White };
        }

        public static void LoginDone()
        {
            MasterDetail myMaster = new MasterDetail();
            portableDetail = myMaster.Detail;
            MyApp.MainPage = myMaster;
        }

        protected override void OnStart()
        {
            // Handle when your app starts
        }

        protected override void OnSleep()
        {
            // Handle when your app sleeps
        }

        protected override void OnResume()
        {
            // Handle when your app resumes
        }
    }
}
