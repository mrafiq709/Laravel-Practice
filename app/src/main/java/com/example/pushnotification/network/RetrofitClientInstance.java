package com.example.pushnotification.network;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class RetrofitClientInstance {
    /**
     * For static method we need static variable/object/instance
     * We have used these variable in static method
     */
    private static Retrofit retrofit;

    // Predefined BASE_URL
    private static final String BASE_URL = "http://192.168.0.102/";

    /**
     * static -> So that we can access this method from all class
     * This method will create retrofit instance according to BASE_URL
     * @param BASE_URL -> Base url of API
     * @return -> Instance of retrofit
     */
    public static Retrofit getRetrofitInstance(String BASE_URL) {

        retrofit = new retrofit2.Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        return retrofit;
    }

    /**
     * static -> So that we can access this method from all class
     * This method will create retrofit instance according to Predefined BASE_URL
     * @return  -> Instance of retrofit
     */
    public static Retrofit getRetrofitInstance() {

        retrofit = new retrofit2.Retrofit.Builder()
                .baseUrl(BASE_URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        return retrofit;
    }
}
