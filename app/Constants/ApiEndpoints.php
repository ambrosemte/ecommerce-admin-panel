<?php

namespace App\Constants;

class ApiEndpoints
{
    //const BASE_URL = "https://backend-ecommerce.mtedev.com.ng";
    const BASE_URL = "http://127.0.0.1:8000";

    // AUTH
    const LOGIN = "/api/v1/auth/seller/login";
    const LOGIN_VIA_GOOGLE = "/api/v1/auth/login-via-google";
    const REGISTER = "/api/v1/auth/register";
    const LOGOUT = "/api/v1/auth/logout";

    // USER
    const GET_PROFILE = "/api/v1/user/profile";
    const CHECK_AUTH = "/api/v1/user/check-authentication";
    const LIST_USERS = "/api/v1/user/all";


    // STORE
    const LIST_STORES = "/api/v1/store/all";


    // PRODUCT
    const LIST_PRODUCTS = "/api/v1/product";
    const CREATE_PRODUCT = "/api/v1/product/create";
    const VIEW_PRODUCT = "/api/v1/product";
    const UPDATE_PRODUCT = "/api/v1/product/{id}/update";
    const DELETE_PRODUCT = "/api/v1/product";

    // ORDER
    const LIST_ORDERS = "/api/v1/order";
    const VIEW_ORDER = "/api/v1/order";
    const ACCEPT_ORDER = "/api/v1/order/accept";
    const DECLINE_ORDER = "/api/v1/order/decline";

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

}
