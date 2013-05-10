<?php

namespace Itools\InotesBundle\Controller;

use Itools\InotesBundle\Document\Note;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {

        $note = new Note();
        $note->setText($name);
        $note->setUserId("noob");

        $dm = $this->get('doctrine_mongodb')->getManager();

        $dm->persist($note);
        $dm->flush();

        return new Response('Created note id '.$note->getId() ."<br/>\n");
        //return $this->render('ItoolsInotesBundle:Default:index.html.twig', array('name' => $name));
    }

    public function createAction($userId){

        /**
         * @var Note $note
         */
        $note;

        $format = 'json'; //$this->getRequest()->getRequestFormat();
        $payload = $this->getRequest()->getContent();

        $serializer = $this->get("jms_serializer");
        $note = $serializer->deserialize($payload,'Itools\InotesBundle\Document\Note',$format);
        $note->setUserId($userId);

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($note);
        $dm->flush();

        $payload = $serializer->serialize($note,$format);
        return new Response($payload);
    }


    public function readAction($userId, $id){
        /**
         * @var Note $note
         */
        $note;

        $format = 'json'; //$this->getRequest()->getRequestFormat();

        $dm = $this->get('doctrine_mongodb')->getManager();
        $note = $dm->getRepository('ItoolsInotesBundle:Note')->findOneBy(array("id"=>$id,"userId"=>$userId));

        if(!$note){
            throw $this->createNotFoundException("Note with Id " . $id . " not found for user ". $userId ."!");
        }

        $serializer = $this->get("jms_serializer");
        $payload = $serializer->serialize($note,$format);
        return new Response($payload);

    }

    public function editAction($userId, $id){
        /**
         * @var Note $newNote
         */
        $newNote;
        /**
         * @var Note $oldNote
         */
        $oldNote;

        $format = 'json'; //$this->getRequest()->getRequestFormat();
        $payload = $this->getRequest()->getContent();

        $dm = $this->get('doctrine_mongodb')->getManager();
        $oldNote = $dm->getRepository('ItoolsInotesBundle:Note')->findOneBy(array("id"=>$id,"userId"=>$userId));

        if(!$oldNote){
            throw $this->createNotFoundException("Note with Id " . $id . " not found for user ". $userId ."!");
        }

        $serializer = $this->get("jms_serializer");
        $newNote = $serializer->deserialize($payload,'Itools\InotesBundle\Document\Note',$format);

        $oldNote->setText($newNote->getText());
        //$oldNote->setModificationDate();

        $dm->persist($oldNote);
        $dm->flush();

        $payload = $serializer->serialize($oldNote,$format);
        return new Response($payload);
    }

    public function deleteAction($userId, $id){
        /**
         * @var Note $note
         */
        $note;

        $dm = $this->get('doctrine_mongodb')->getManager();
        $note = $dm->getRepository('ItoolsInotesBundle:Note')->findOneBy(array("id"=>$id,"userId"=>$userId));

        if(!$note){
            throw $this->createNotFoundException("Note with Id " . $id . " not found for user ". $userId ."!");
        }

        $dm->remove($note);
        $dm->flush();

        return new Response();
    }
}
