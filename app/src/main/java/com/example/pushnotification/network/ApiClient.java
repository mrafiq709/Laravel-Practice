package com.example.pushnotification.network;

import com.example.pushnotification.interfaces.ApiServices;
import com.example.pushnotification.model.UserResponse;

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ApiClient {

    private static Retrofit getRetrofit(){

        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl("http://api.larntech.net/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        return retrofit;
    }

    public static ApiServices getUserService() {
        ApiServices service = getRetrofit().create(ApiServices.class);
        return service;
    }
}
