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
		//var_dump($toDoLists);
		$projects = array();
		foreach($toDoLists as $list)
		{
			$tmp = array();
			$projectName = null;
			if (isset($list->bucket))
			{
				$project = $list->bucket;
				unset($list->bucket);

				$projectName = $project->name;

				if (!isset($projects[$project->name]))
				{

					$projects[$projectName]["details"] = $project;
				}
			}

			if (isset($list->creator))
			{
				$tmp['creator'] = $list->creator;
				unset($list->creator);
			}


			$list = $this->api('projects/'. $project->id .'/todolists/'. $list->id .'.json');
			$tmp['list'] = $list;


			var_dump($tmp);
			$projectName = $projectName ? $projectName : "not_a_project";
 			$projects[$projectName]["lists"][] = $tmp;
		}

        return $this->render('ZLIntegrationBundle:HomePage:main.html.twig', array("projects" => $projects));
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
