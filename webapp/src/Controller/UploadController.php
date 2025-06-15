<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadController extends AbstractController
{
	
	#[Route('/upload_image', name: 'film_image_upload_ajax', methods: ['GET', 'POST'])]
	public function upload_image(
		Request $request,
		SluggerInterface $slugger,
	): Response
	{
		$imagesDirectory = $this->getParameter('kernel.project_dir') . '/public/images';
		
		$accepted_origins = array("http://cinephoria.local", "https://cinephoria.guhring.ovh", "http://localhost:8080");
		
		if($request->isXmlHttpRequest())
		{
			//$data = json_decode($request->getContent(), true);
			$message = "Requête AJAX OK";
//			dd($request->getContent());
			
			$response = new Response();
			$image_data = $_POST["image"];
			//dd($image_data);
			
			if (isset($image_data))
			{
				
				$film_titre = $_POST["film_titre"];
				$film_date_ajout = $_POST["film_date_ajout"];
				$champ_source_image = $_POST["champ_source_image"];
				
				if (isset($_SERVER['HTTP_ORIGIN'])) {
					// same-origin requests won't set an origin. If the origin is set, it must be valid.
					if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins))
					{
						$response->headers->set('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
					} else {
						return new Response(json_encode(array('code' => 'erreur', 'name' => $film_titre, 'error' => "Origine '" . $_SERVER['HTTP_ORIGIN'] . "' interdite")), Response::HTTP_FORBIDDEN);
					}
				}
				
				$image_array_1 = explode(";", $image_data);
				$image_array_2 = explode(",", $image_array_1[1]);
				$data = base64_decode($image_array_2[1]);
				
				$film_titre = str_replace("'", "", $film_titre);
				$imageName = strtolower($slugger->slug($film_date_ajout . "-" . $film_titre) . '.jpg');
				
				$dossier_dest = ($champ_source_image == "affiche") ? "/affiches/" : "/bannieres/";
				file_put_contents($imagesDirectory.$dossier_dest.$imageName, $data);
				
				// Respond to the successful upload with JSON.
				// Use a location key to specify the path to the saved image resource.
				$response->setContent(json_encode(array('code' => 'ok', 'dossier_dest' => $dossier_dest, 'name' => $imageName)));
			} else {
				// Notify editor that the upload failed
				$response->setContent(json_encode(array('code' => 'erreur', 'error' => "Erreur : les données requises ne sont pas présentes.")));
			}
			
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}
		return new Response("['error' => 'Cet appel doit être effectué via AJAX.']", Response::HTTP_BAD_REQUEST);
		
	}
	
	
	
}