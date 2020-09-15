<?php

namespace MM\SamyChan\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use MM\SamyChan\BackendBundle\Scm;
use MM\SamyChan\BackendBundle\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatsController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine');
        $latestPackages = $em->getRepository('MM\SamyChan\BackendBundle\Entity\ScmPackage')->findBy(array(),array('scm_package_id'=>'DESC'),100,0);
        $data = [];
        foreach ($latestPackages as $latestPackage) {
            $data[] = [
                'hash' => $latestPackage->getHash(),
                'filename' => $latestPackage->getFilename(),
                'series' => $latestPackage->getSeries()
            ];
        }

        $response = new JsonResponse();
        $response->setData($data);

        return $response;
    }
}