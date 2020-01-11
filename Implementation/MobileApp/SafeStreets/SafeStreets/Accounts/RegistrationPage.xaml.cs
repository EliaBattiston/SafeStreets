using Plugin.Media;
using System;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SafeStreets
{
	[XamlCompilation(XamlCompilationOptions.Compile)]
	public partial class RegistrationPage : ContentPage
	{
        private string imageBase64;

		public RegistrationPage ()
		{
			InitializeComponent ();
		}

        private async void onCameraButtonClicked(object sender, EventArgs e)
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
                Name = "id.jpg",
                CompressionQuality = 50
            });

            if (photo != null)
            {
                xPhotoImage.Source = ImageSource.FromStream(() => { return photo.GetStream(); });
                xPhotoImage.IsVisible = true;
                xCameraButton.Text = "Change Picture";

                byte[] b = System.IO.File.ReadAllBytes(photo.Path);
                imageBase64 = Convert.ToBase64String(b);
            }
        }

        private async void OnSignUpClicked(object sender, EventArgs e)
        {
            string email, username, firstName, lastName, fiscalCode, password;

            email = xEmailEntry.Text;
            username = xUsernameEntry.Text;
            firstName = xFirstNameEntry.Text;
            lastName = xLastNameEntry.Text;
            fiscalCode = xFiscalCodeEntry.Text;
            password = xPasswordEntry.Text;

            if(Utils.HasText(email) && Utils.HasText(username) && Utils.HasText(firstName) && Utils.HasText(lastName) && Utils.HasText(fiscalCode) && Utils.HasText(password))
            {
                if (Utils.HasText(imageBase64))
                {
                    xLoader.IsVisible = true;
                    xForm.IsVisible = false;
                    

                    SimpleCallAnswer answer = await JsonRequest.Registration(email, username, firstName, lastName, fiscalCode, password, imageBase64);

                    xLoader.IsVisible = false;
                    xForm.IsVisible = true;

                    if (answer != null)
                    {
                        if(answer.result == 200) 
                        {
                            await DisplayAlert("Done!", "The registration has been done!", "Ok");
                            await Navigation.PopModalAsync();
                        }
                        else
                        {
                            await DisplayAlert("Error " + answer.result, answer.message, "Ok");
                        }
                    }
                    else
                    {
                        await DisplayAlert("Error!", "An error occurred during your registration!", "Ok");
                    }
                }
                else
                {
                    await DisplayAlert("Missing ID!", "A picture of your ID is needed in order to register!", "Ok");
                }
            }
            else
            {
                await DisplayAlert("Missing data!", "All the entries are required in order to register!", "Ok");
            }
        }

        //tolbar closeModal button handler
        async void OnCloseModalClicked(object sender, System.EventArgs e)
        {
            if (xLoader.IsVisible == false)
                await Navigation.PopModalAsync();
            else
                await DisplayAlert("Loading...", "We are uploading your ID picture. Please wait a while!", "Ok");
        }
    }
}