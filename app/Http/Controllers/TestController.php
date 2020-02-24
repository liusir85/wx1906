<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class TestController extends Controller
{
    public function curlPost1(){
//        echo __METHOD__;

        $user_info=[
            'user_name'=>'liusir',
            'password'=>'123123'
        ];
        $url='http://api.1906.com/test/wx/post1';

        //初始化
        $ch=curl_init($url);

        $str="name=liusir&age=99999";     //urlencoded 格式

        //设置参数
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($ch,CURLOPT_POST,1);
//        curl_setopt($ch,CURLOPT_POSTFIELDS,$user_info);     //form-data
        curl_setopt($ch,CURLOPT_POSTFIELDS,$str);     //x-www-formurlencoded

        //开启会话
        $response=curl_exec($ch);
        var_dump($response);
        //铺货错误
        $errno=curl_errno($ch);
        if($errno > 0)
        {
            echo curl_error();
            die;
        }
        //关闭会话
        curl_close($ch);
    }

    //项目接口post json 字符串
    public function curlPost3(){
        $user_info=[
            'user_name'=>'liusir',
            'password'=>'99999666'
        ];
        $json=json_encode($user_info);

        $url='http://api.1906.com/test/wx/post3';

        //初始化
        $ch=curl_init($url);

        //设置参数
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);     //form-data

        //开启会话
        $response=curl_exec($ch);
        var_dump($response);
        //铺货错误
        $errno=curl_errno($ch);
        if($errno > 0)
        {
            echo curl_error();
            die;
        }
        //关闭会话
        curl_close($ch);
    }

    //访问接口 上传文件
    public function curlUpload(){
        $file_info=[
            'user_name'=>'liusir',
            'password'=>'99999666',
            'img' => new \CURLFile('yi.jpg')
        ];
        $url='http://api.1906.com/test/wx/upload';


        //初始化
        $ch=curl_init($url);

        //设置参数
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$file_info);     //form-data

        //开启会话
        $response=curl_exec($ch);
        var_dump($response);
        //铺货错误
        $errno=curl_errno($ch);
        if($errno > 0)
        {
            echo "错误码:".$errno;
            echo curl_error($ch);
            die;
        }
        //关闭会话
        curl_close($ch);
    }

    public function guzzleGet1(){
        $client=new Client();
        $url="http://api.1906.com/test/wx/get1";
        $response=$client->request('GET',$url,[
            'query' =>[
                'user' => "liusir123",
                'name' => "chaoren"
            ]
        ]);
        echo $response->getBody();  //接收服务器响应

    }

    public function guzzlePost1(){
        $client=new Client();
        $url="http://api.1906.com/test/wx/post1";
        $response=$client->request('POST',$url,[
            'form_params' =>[
                'user' => "liu",
                'name' => "shen"
            ]
        ]);
        echo $response->getBody();  //接收服务器响应
    }

    //上传文件
    public function guzzlePost2(){
        $client=new Client();
        $url="http://api.1906.com/test/wx/post1";
        $response=$client->request('POST',$url,[
            'multipart'=>[
                [
                    'name'=>"user_name",
                    'contents'=>"liu123"
                ],
                [
                    'name'=>'logo',
                    'contents'=>fopen('yi.jpg','r')
                ]
            ]
        ]);

        echo $response->getBody();
    }

    public function test1(){
        $key="uzi";
        $data="Hello";
        $number="11111";
        //接口服务器地址
        $url="http://1905liuqingyuan.comcto.com/test/md5Test2?data=".$data.'&number='.$number;   //接口线上地址
        echo $url;echo "<br>";

        //todo 签名
        $response=file_get_contents($url);
        var_dump($response);
    }

    public function encrypt(){
        //ord
        $str='Hello';
//        echo "原文：".$str;echo "<br>";
        $length=strlen($str);  //获取字符串长度
//        echo "length：".$length;echo "<hr>";
        $new_str='';
        for($i=0;$i<$length;$i++)
        {
            echo $str[$i] . '>' . ord($str[$i]);echo "<br>";
            $code=ord($str[$i]) + 1;
            echo "编码 $str[$i]" . '>' .$code . '>' . chr($code);echo "<br>";
            $new_str .=chr($code);
        }

        //请求接口将加密数据发送
        $url = 'http://api.1906.com/test/decrypt?data='.$new_str;
        $response=file_get_contents($url);
        var_dump($response);
    }

    public function decrypt(){
        $data='Ifmmp!Xpsme';
        echo "密文".$data;echo "<br>";

        //解密
        $length=strlen($data);

        $str='';
        for($i=0;$i<$length;$i++){
            echo $data[$i] . '>' .ord($data[$i]);echo "<br>";
            $code=ord($data[$i])-1;
            echo "解码" .$data[$i] . '>' . chr($code);echo "<br>";
            $str .=chr($code);
        }
        echo "解密后数据：". $str;
    }

    public function encrypt1(){
//        $method_arr=openssl_get_cipher_methods();
//        echo "<pre>";print_r($method_arr);echo "</pre>";
//        die;
//        $data='hello'; //要加密的数据
//        $method='';  //要的加算法

        $key='666';
        $data='hello';  //要加密数据
        $method='aes-128-cbc';   //加算法
        $iv='abcdefg1234zxcdf';  //必须为16个

        //加密
        $enc_str=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "原始数据：".$data;echo "<br>";
        echo "加密后的密文：".$enc_str;echo "<br>";

        //base64编码
        $base64_str=base64_encode($enc_str);
        echo "base64编码的密文：".$base64_str;

//        //解密
//        $dec_data=openssl_decrypt($enc_str,$method,$key,OPENSSL_RAW_DATA,$iv);
//        var_dump($dec_data);

        //将加密后的数据发送出
        $url="http://api.1906.com/test/decrypt1?data=".$base64_str;
        $response=file_get_contents($url);
        var_dump($response);
    }
}