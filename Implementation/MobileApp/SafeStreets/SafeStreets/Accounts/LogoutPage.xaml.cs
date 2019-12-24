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
	public partial class LogoutPage : ContentPage
	{
		public LogoutPage ()
		{
			InitializeComponent ();
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