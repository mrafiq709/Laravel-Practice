package com.example.pushnotification;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.os.Bundle;
import android.provider.Settings;
import android.util.Log;
import android.widget.Toast;

import com.example.pushnotification.interfaces.ApiServices;
import com.example.pushnotification.model.Device;
import com.example.pushnotification.network.RetrofitClientInstance;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        String pushToken =  MyFirebaseService.getToken(getApplicationContext());

        String deviceToken = Settings.Secure.getString(getApplicationContext().getContentResolver(),
                Settings.Secure.ANDROID_ID);

        saveDeviceToken("android", deviceToken, pushToken);
    }

    private void saveDeviceToken(String type, String deviceToken, String pushToken){
        ApiServices service = RetrofitClientInstance.getRetrofitInstance().create(ApiServices.class);
        Call<Device> call = service.createPushToken("/Laravel-Practice/public/api/device", type, deviceToken, pushToken);
        call.enqueue(new Callback<Device>() {
            @Override
            public void onResponse(Call<Device> call, Response<Device> response) {
                if (response.isSuccessful()){
                    Log.d("rafiq", "Response: " + response.body().getMessage());
                }
            }

            @Override
            public void onFailure(Call<Device> call, Throwable t) {
                Log.d("error", "onFailure: " + t.getMessage());
            }
        });
    }
}