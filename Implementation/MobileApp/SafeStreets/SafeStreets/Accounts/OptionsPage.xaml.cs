using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Essentials;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class OptionsPage : ContentPage
	{
		public OptionsPage ()
		{
			InitializeComponent ();
		}

        private async void OnBtnChangePasswordClicked(object sender, EventArgs e)
        {
            string oldPass = xOldPwd.Text;
            string newPass = xNewPwd.Text;

            if (Utils.HasText(oldPass) && Utils.HasText(newPass))
            {
                var conferma = await DisplayAlert("Confirm", "Do you really want to change your old password into the new one?", "Yes", "No");
                if (conferma)
                {
                    SimpleCallAnswer answer = await JsonRequest.ChangePassword(App.username, oldPass, newPass);

                    if(answer != null)
                    {
                        if (answer.result == 200)
                        {
                            await DisplayAlert("Done!", "Your password has been changed, please re-login to continue", "Ok");

                            //After the change log out from the app
                            App.IsUserLoggedIn = false;

                            SecureStorage.RemoveAll();

                            App.GoToLoginPage();
                        }
                        else
                            await DisplayAlert("Error", answer.message, "Ok");
                    }
                    else
                        await DisplayAlert("Error", "Error during the request", "Ok");
                }
            }
        }

        private async void OnBtnLogoutClicked(object sender, EventArgs e)
        {
            var confermaLogout = await DisplayAlert("Logout", "Do you really want to Log Out from the SafeStreets App?", "Log Out", "Cancel");
            if (confermaLogout)
            {
                App.IsUserLoggedIn = false;

                SecureStorage.RemoveAll();

                App.GoToLoginPage();
            }
        }
    }
}