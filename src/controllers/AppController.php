<?php namespace SiTwi\Controllers;

use SiTwi\Models\Post;
use SiTwi\Models\User;

class AppController
{

    public function __construct(\Silex\Application $app)
    {
		// Not a fan of this and there is likely a better way
        $this->app = $app;
    }

    public function home()
    {
		$app = $this->app;
		
		// If the user isn't logged in, make 'em login
        if (null === $user = $app['session']->get('user')) {
        	return $app->redirect($app['url_generator']->generate('login'));
        }
		
		// Otherwise load the page and include the most recent 20 posts.
		return $this->app['twig']->render('hello.html', array(
			'name' => $user['username'],
			'posts' => Post::orderBy('created_at', 'DESC')->limit(20)->get(),
		));
    }
	
	public function post()
	{
		$app = $this->app;
		
		// Get the posted data
		$username = $app['request']->get('username');
		$content = $app['request']->get('content');
		
		// Add a post
		Post::create(array('username' => $username, 'content' => substr($content, 0, 140)));
		
		// Send 'em back so they can see it and post more
		return $app->redirect($app['url_generator']->generate('home'));
	}
	
	public function login()
	{
		// Display the login form...simple enough
		return $this->app['twig']->render('login.html');
	}
	
	public function authenticate()
	{
		$app = $this->app;
		
		// Get the posted data
		$username = $app['request']->get('username');
		$password = $app['request']->get('password');
		
		// Find the user
		$user = User::where('username', $username)->first();

		// Validate password, then set session and redirect them
		if ($user && $user->password === $password) {
			$app['session']->set('user', $user);
			return $app->redirect($app['url_generator']->generate('home'));
		}
		
		// Or tell them things are no bueno.
		return "Are you really who you say you are? Try again.";
	}
	
	public function logout()
	{
		// Clear session
		$this->app['session']->remove('user');
		
		// Let 'em log in again
		return $this->app->redirect($this->app['url_generator']->generate('login'));
	}
	
	public function createUserForm()
	{
		// Display the create user form
		return $this->app['twig']->render('create.html');
	}
	
	public function createUser()
	{
		$app = $this->app;
		
		// Get the posted data
		$username = $app['request']->get('username');
		$password = $app['request']->get('password');
		
		// Create the user
		User::create(array('username' => $username, 'password' => $password));
		
		// Let them log in
		return $app->redirect($this->app['url_generator']->generate('login'));
	}
}