<?php

namespace ZL\IntegrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ZL\IntegrationBundle\Entity\User;
use ZL\IntegrationBundle\Form\User\LoginUser;

class HomePageController extends Controller
{
    public function loginAction(Request $request)
    {
		$form = $this->createForm(new LoginUser(), new User());
		
		if ($request->getMethod() == 'POST') 
		{
			
            $form->bindRequest($request);
			
            if ($form->isValid()) 
			{
			
				$user = $form->getData();
				
                $session  = $this->get("session");
				$session->set('user', $user);

				$url = $this->generateUrl("main");
				return $this->redirect($url);
            }
			
		}
		
        return $this->render('ZLIntegrationBundle:HomePage:login.html.twig', array('form' => $form->createView()));
    }
	
	public function mainAction()
    {
		$toDoLists = $this->api("todolists.json");

		$structure = array();
		foreach($toDoLists as $list)
		{
			$tmp = array();
			if (isset($list->bucket))
			{
				$tmp['project'] = $list->bucket;
				unset($list->bucket);
			}

			if (isset($list->creator))
			{
				$tmp['creator'] = $list->creator;
				unset($list->creator);
			}

			$tmp['list'] = $list;

			$structure[] = $tmp;
		}
		/*foreach($result as $project)
		{
			$toDoList = $this->api("projects/". $project['id'] . "todolists.json");
			$projects[$project['id']]['project'] = $project;
			$projects[$project['id']]['todolist'] = $toDoList;
		}*/
		var_dump($structure);
		#var_dump($result);

        return $this->render('ZLIntegrationBundle:HomePage:main.html.twig', array("structure" => $structure));
    }

	public function api($method)
	{
		$session  = $this->get("session");
		$user = $session->get('user');

		$session = curl_init();

		$basecamp_url = 'https://basecamp.com/1758651/api/v1/';
		$username = $user->getLogin();
		$password = $user->getPassword();

		curl_setopt($session, CURLOPT_URL, $basecamp_url.$method);
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($session, CURLOPT_HTTPGET, 1);
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($session, CURLOPT_USERAGENT, 'MyApp (yourname@example.com)');
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($session,CURLOPT_USERPWD,$username . ":" . $password);



		$response = curl_exec($session);

		curl_close($session);

		$response = json_decode($response);
		return $response;
	}

	public function changeCollecionKeys($collection, $key)
	{

	}
}
