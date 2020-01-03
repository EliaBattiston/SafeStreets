using System;
using Xamarin.Essentials;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;


//[assembly: XamlCompilation(XamlCompilationOptions.Compile)]
namespace SafeStreets
{
    public partial class LoginPage : ContentPage //deriva da ContentPage
    {
        //private UserData myUser { get; set; }

        public LoginPage()
        {
            InitializeComponent();

            xLogoImage.Source = ImageSource.FromResource("SafeStreets._Images.logo.png");
        }

        async void OnLoginButtonClicked(object sender, EventArgs e)
        {
            //await Navigation.PushAsync(new LoadingPage()); //Loading page
            

            string username, pass;

            username = xUsername.Text;
            pass = xPassword.Text;

            if (username != string.Empty && pass != string.Empty)
            {
                var answer = await JsonRequest.Login(username, pass);

                if (answer != null)
                {
                    if(answer.result == 200)
                    {
                        App.username = username;
                        App.pass = pass;
                        try
                        {
                            await SecureStorage.SetAsync("username", username);
                            await SecureStorage.SetAsync("pass", pass);
                        }
                        catch (Exception ex)
                        {
                            // Possible that device doesn't support secure storage on device.
                        }

                        //Apro la MasterDetailPage
                        App.LoginDone();
                        return;//per sicurezza
                    }
                    else
                    {
                        await DisplayAlert("Error " + answer.result, answer.message, "Ok");
                    }
                }
                else
                {
                    await DisplayAlert("Attention!", "Username or Password wrong!", "Ok");
                    xPassword.Text = string.Empty;
                    //await Navigation.PopAsync();//Togli loading page
                }
            }
            else
                await DisplayAlert("Error", "Insert username and password to continue.", "Ok");
            
        }

        async void OnRestoreCredentialClicked(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new RestoreCredentialsPage()) { BarTextColor = Color.White });
        }

        async void OnSignUpClicked(object sender, EventArgs e)
        {
            await Navigation.PushModalAsync(new NavigationPage(new RegistrationPage()) { BarTextColor = Color.White });
        }
    }
}
