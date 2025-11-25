<?php

namespace App\Constants;

class ApiEndpoints
{
    //const BASE_URL = "https://backend-ecommerce.mtedev.com.ng";
    const BASE_URL = "http://127.0.0.1:8000";

    // AUTH
    const LOGIN = "/api/v1/auth/login";
    const LOGIN_VIA_GOOGLE = "/api/v1/auth/login-via-google";
    const REGISTER = "/api/v1/auth/register";
    const LOGOUT = "/api/v1/auth/logout";

    // USER
    const GET_PROFILE = "/api/v1/user/profile";
    const CHECK_AUTH = "/api/v1/user/check-authentication";
    const LIST_USERS = "/api/v1/user/all";

    //DASHBOARD
    const GET_DASHBOARD = "/api/v1/dashboard/admin";

    // STORE
    const LIST_STORES = "/api/v1/store/all";


    // PRODUCT
    const LIST_PRODUCTS = "/api/v1/product/all";
    const CREATE_PRODUCT = "/api/v1/product/create";
    const VIEW_PRODUCT = "/api/v1/product";
    const UPDATE_PRODUCT = "/api/v1/product/{id}/update";
    const DELETE_PRODUCT = "/api/v1/product";

    // ORDER
    const LIST_ORDERS = "/api/v1/order";
    const VIEW_ORDER = "/api/v1/order";
    const ACCEPT_ORDER = "/api/v1/order/accept";
    const DECLINE_ORDER = "/api/v1/order/decline";
    const PROCESS_ORDER = "/api/v1/order/process";
    const SHIP_ORDER = "/api/v1/order/ship";
    const OUT_FOR_DELIVERY_ORDER = "/api/v1/order/out-for-delivery";
    const DELIVERED_ORDER = "/api/v1/order/delivered";

    const APPROVE_REFUND_ORDER = "/api/v1/order/approve-refund";
    const DECLINE_REFUND_ORDER = "/api/v1/order/decline-refund";


    //CATEGORY
    const LIST_CATEGORIES = "/api/v1/category";
    const CREATE_CATEGORY = "/api/v1/category";
    const VIEW_CATEGORY = "/api/v1/category";
    const EDIT_CATEGORY = "/api/v1/category";
    const DELETE_CATEGORY = "/api/v1/category";

    //SPECIFICATION
    const LIST_SPECIFICATIONS_BY_CATEGORY = "/api/v1/specification";
    const CREATE_SPECIFICATION = "/api/v1/specification";
    const EDIT_SPECIFICATION = "/api/v1/specification";
    const DELETE_SPECIFICATION = "/api/v1/specification";

    //CHATS
    const LIST_CONVERSATIONS = "/api/v1/chat/conversation/agent";
    const JOIN_CONVERSATION = "/api/v1/chat/conversation";
    const CLOSE_CONVERSATION = "/api/v1/chat/conversation";
    const TRANSFER_CONVERSATION = "/api/v1/chat/conversation";
    const VIEW_CHAT = "/api/v1/chat/messages";
    const SEND_MESSAGE = "/api/v1/chat/send";

    //SHIPPING
    const LIST_SHIPPING_METHODS = "/api/v1/shipping/method";
    const CREATE_SHIPPING_METHOD = "/api/v1/shipping/method";
    const EDIT_SHIPPING_METHOD = "/api/v1/shipping/method";
    const LIST_SHIPPING_ZONES = "/api/v1/shipping/zone";
    const CREATE_SHIPPING_ZONE = "/api/v1/shipping/zone";
    const EDIT_SHIPPING_ZONE = "/api/v1/shipping/zone";
    const LIST_SHIPPING_RATES = "/api/v1/shipping/rate";
    const CREATE_SHIPPING_RATE = "/api/v1/shipping/rate";
    const VIEW_SHIPPING_RATE = "/api/v1/shipping/rate";

    //COUNTRY
    const LIST_COUNTIRES = "/api/v1/csc/countries";
    const LIST_STATES = "/api/v1/csc";
    const LIST_CITIES = "/api/v1/csc";

    //REVIEW
    const LIST_REVIEWS = "/api/v1/review/all";
    const APPROVE_REVIEW = "/api/v1/review/approve";
    const DECLINE_REVIEW = "/api/v1/review/decline";

    // STORY
    const LIST_STORIES = "/api/v1/story/all";

    //PROMO BANNER
    const LIST_PROMO_BANNER = "/api/v1/promo-banner/all";
    const VIEW_PROMO_BANNER = "/api/v1/promo-banner";
    const DELETE_PROMO_BANNER = "/api/v1/promo-banner";

}
