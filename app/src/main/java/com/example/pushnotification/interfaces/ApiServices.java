package com.example.pushnotification.interfaces;

import com.example.pushnotification.BuildConfig;
import com.example.pushnotification.model.Device;
import com.example.pushnotification.model.UserResponse;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.Headers;
import retrofit2.http.POST;
import retrofit2.http.Url;

public interface ApiServices {
    @Headers("x-api-key:"+ BuildConfig.API_KEY)
    @POST()
    @FormUrlEncoded
    Call<Device> createPushToken(
            @Url String url,
            @Field("type") String type,
            @Field("device_token") String device_token,
            @Field("push_token") String push_token
    );
}
