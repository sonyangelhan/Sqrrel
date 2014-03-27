<?php

class Api extends CI_Controller
{
    
    // ------------------------------------------------------------------------
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('todo_model');
        $this->load->model('note_model');
        $this->load->model('com_model');
        $this->load->library('curl');
    }

    // ------------------------------------------------------------------------
    
    private function _require_login()
    {
        if ($this->session->userdata('user_id') == false) {
            $this->output->set_output(json_encode(array('result' => 0, 'error' => 'You are not authorized.')));
            return false;
        }
    }
    
    // ------------------------------------------------------------------------

    
    public function login()
    {
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        $result = $this->user_model->get(array(
            'login' => $login,
            'password' => hash('sha256', $password . SALT)
        ));
        
        $this->output->set_content_type('application_json');
        
        if ($result) {
            $this->session->set_userdata(array('user_id' => $result[0]['user_id']));
            $this->session->set_userdata(array('com_id' => $result[0]['com_id']));
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array('result' => 0)));
    }
    
    // ------------------------------------------------------------------------
    //Sony Mar 25
    
    public function register()
    {
        $this->output->set_content_type('application_json');
        
        $this->form_validation->set_rules('login', 'Login', 'required|min_length[4]|max_length[16]|is_unique[user.login]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[16]|matches[confirm_password]');
        $this->form_validation->set_rules('com_password', 'Company Password', 'required|min_length[4]|max_length[16]|matches[com_confirm_password]');
        
        if ($this->form_validation->run() == false) {
            $this->output->set_output(json_encode(array('result' => 0, 'error' => $this->form_validation->error_array())));
            return false;
        }
        
        $login = $this->input->post('login');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $com_password = $this->input->post('com_password');
        $com_confirm_password = $this->input->post('com_confirm_password');

        $result = $this->com_model->get(array(
            'com_password' => hash('sha256', $com_password . SALT)
        ));
        
        //$this->output->set_content_type('application_json');
        
        if ($result) {
            $this->session->set_userdata(array('com_id' => $result[0]['com_id']));
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array('result' => 0)));

        $user_id = $this->user_model->insert(array(
            'login' => $login,
            'password' => hash('sha256', $password . SALT),
            'email' => $email,
            'com_id' => $this->session->userdata('com_id')
        ));
        
        if ($user_id) {
            $this->session->set_userdata(array('user_id' => $user_id));
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array('result' => 0, 'error' => 'User not created.')));
    }

    // ------------------------------------------------------------------------
    //Register Company -  Sony Mar 24
    
    public function register_com()
    {
        $this->output->set_content_type('application_json');
        
        $this->form_validation->set_rules('com_name', 'Company name', 'required|min_length[4]|max_length[16]|is_unique[com.com_name]');
        $this->form_validation->set_rules('com_password', 'Company Password', 'required|min_length[4]|max_length[16]|matches[confirm_password]');
        
        if ($this->form_validation->run() == false) {
            $this->output->set_output(json_encode(array('result' => 0, 'error' => $this->form_validation->error_array())));
            return false;
        }
        
        $com_name = $this->input->post('com_name');
        $password = $this->input->post('com_password');
        $confirm_password = $this->input->post('confirm_password');

        $com_id = $this->com_model->insert(array(
            'com_name' => $com_name,
            'com_password' => hash('sha256', $password . SALT),
        ));
        
        if ($com_id) {
            $this->session->set_userdata(array('com_id' => $com_id));
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array('result' => 0, 'error' => 'Company not created.')));
    }
    
    // ------------------------------------------------------------------------

    public function get_todo($id = null)
    {
        $this->_require_login();
        
        if ($id != null) {
            $result = $this->todo_model->get(array(
                'todo_id' => $id,
                'com_id' => $this->session->userdata('com_id')
            ));
        } else {
            $result = $this->todo_model->get(array(
                'com_id' => $this->session->userdata('com_id')
            ));
        }
        
        $this->output->set_output(json_encode($result));
    }
    
    // ------------------------------------------------------------------------
    
    public function create_todo()
    {
        $this->_require_login();
        
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[255]');
        if ($this->form_validation->run() == false) {
            $this->output->set_output(json_encode(array(
                'result' => 0,
                'error' => $this->form_validation->error_array()
            )));
            
            return false;
        }
        
        $result = $this->todo_model->insert(array(
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id'),
            'com_id' => $this->session->userdata('com_id')
        ));
        
        if ($result) {
            
            // Get the freshest entry for the DOM
            
            $this->output->set_output(json_encode(array(
                'result' => 1,
                'data' => array(
                    'todo_id' => $result,
                    'content' => $this->input->post('content'),
                    'complete' => 0
                )
            )));
            return false;
        }
        $this->output->set_output(json_encode(array(
            'result' => 0,
            'error' => 'Could not insert record'
        )));
    }
    
    // ------------------------------------------------------------------------
    
    public function update_todo()
    {
        $this->_require_login();
        $todo_id = $this->input->post('todo_id');
        $completed = $this->input->post('completed');
        
        $result = $this->todo_model->update(array(
            'completed' => $completed
        ), $todo_id);
        
        if ($result) {
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array('result' => 0)));
        return false;
    }
    
    // ------------------------------------------------------------------------
    
    public function delete_todo()
    {
        $this->_require_login();
        
        $result = $this->todo_model->delete(array(
            'todo_id' => $this->input->post('todo_id'),
            'user_id' => $this->session->userdata('user_id')
        ));
        
        if ($result) {
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array(
            'result' => 0,
            'message' => 'Could not delete.'
        )));
    }
    
    // ------------------------------------------------------------------------

    public function get_note($id = null)
    {
        $this->_require_login();
        
        if ($id != null) {
            $result = $this->note_model->get(array(
                'note_id' => $id,
                'com_id' => $this->session->userdata('com_id')
            ));
        } else {
            $result = $this->note_model->get(array(
                'com_id' => $this->session->userdata('com_id')
            ));
        }
        
        $this->output->set_output(json_encode($result));
    }
    
    // ------------------------------------------------------------------------
    
    public function create_note()
    {
        $this->_require_login();
        
        $this->form_validation->set_rules('title', 'title', 'required|max_length[50]');
        $this->form_validation->set_rules('content', 'Content', 'required|max_length[500]');
        if ($this->form_validation->run() == false) {
            $this->output->set_output(json_encode(array(
                'result' => 0,
                'error' => $this->form_validation->error_array()
            )));
            
            return false;
        }
        
        $result = $this->note_model->insert(array(
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'user_id' => $this->session->userdata('user_id'),
            'com_id' => $this->session->userdata('com_id')
        ));
        
        if ($result) {
            
            // Get the freshest entry for the DOM
            $this->output->set_output(json_encode(array(
                'result' => 1,
                'data' => array(
                    'note_id' => $result,
                    'title' => $this->input->post('title'),
                    'content' => $this->input->post('content'),
                )
            )));
            return false;
        }
        $this->output->set_output(json_encode(array(
            'result' => 0,
            'error' => 'Could not insert record'
        )));
    }
    
    // ------------------------------------------------------------------------
    
    public function update_note()
    {
        $this->_require_login();
        
        $note_id = $this->input->post('note_id');
        
        $result = $this->note_model->update(array(
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content')
        ), $note_id);

        // Do not check the $result because if no affected rows happen
        // they will think its an error
        
        $this->output->set_output(json_encode(array('result' => 1)));
        return false;
    }
    
    // ------------------------------------------------------------------------
    
    public function delete_note()
    {
        $this->_require_login();
        
        $result = $this->note_model->delete(array(
            'note_id' => $this->input->post('note_id'),
            'user_id' => $this->session->userdata('user_id')
        ));
        
        if ($result) {
            $this->output->set_output(json_encode(array('result' => 1)));
            return false;
        }
        
        $this->output->set_output(json_encode(array(
            'result' => 0,
            'message' => 'Could not delete.'
        )));
    }
    
    // ------------------------------------------------------------------------
    
/* Terry's update */
/* to store token and secret in sessions */
    public function twitterOath()
    {
        $token = $this->input->post('token');
        $secret = $this->input->post('secret');
        $this->session->set_userdata(array('twitterToken' => $token, 'twitterSecret' => $secret));
//        echo "token = $token<br>";
//        echo "secret = $secret";

        redirect ('/dashboard');
    }


/* send query to twitter api */

    public function getTweets(){
        require_once(APPPATH.'libraries/TwitterAPIExchange.php');
        $q = $this->input->get('query', TRUE);

        $token = $this->session->userdata('twitterToken');
        $secret = $this->session->userdata('twitterSecret');

        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => $token,
            'oauth_access_token_secret' => $secret,
            'consumer_key' => "uH1Sqmg4zX6cp3Flc6ICw",
            'consumer_secret' => "8IZdciwJtyH1t5ilBMqSoyk0qk1CrC3MbyWz1sQNM"
        );


        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q='.$q;
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);

        $data =  $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        $dataArray = json_decode($data,true);
        $tweets = array();

        foreach ($dataArray['statuses'] as $key => $value) {
//            echo $value['id'].'<br>';

            $res = $this->curl->simple_get('https://api.twitter.com/1/statuses/oembed.json?id='.$value['id']);
            $resArray = json_decode($res,true);

            $tweets[] = $resArray['html'];
            # code...
        }
        $tweetsJson = json_encode($tweets);
        echo $tweetsJson;
//        print_r($tweets);
    }

    public function tweetTest(){
        require_once(APPPATH.'libraries/TwitterAPIExchange.php');

        $token = $this->session->userdata('twitterToken');
        $secret = $this->session->userdata('twitterSecret');

        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token' => $token,
            'oauth_access_token_secret' => $secret,
            'consumer_key' => "uH1Sqmg4zX6cp3Flc6ICw",
            'consumer_secret' => "8IZdciwJtyH1t5ilBMqSoyk0qk1CrC3MbyWz1sQNM"
        );


        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=terry';
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);

        $data =  $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();

        var_dump($data);

        $dataArray = json_decode($data,true);
        print_r($dataArray);
    }

}