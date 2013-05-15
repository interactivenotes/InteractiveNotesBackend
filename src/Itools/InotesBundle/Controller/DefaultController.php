<?php

namespace Itools\InotesBundle\Controller;

use Doctrine\Common\Collections\Collection;
use Itools\InotesBundle\Document\Note;
use Itools\InotesBundle\Document\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {

        $note = new Note();
        $note->setText($name);
        $note->setUserId("noob");
        $note->setTags(array("tag A", "tag B"));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($note);

        $dm->flush();

        return new Response('Created note id '.$note->getId() ."<br/>\n");
    }




    public function listAction($userId){

        /**
         * @var Collection<Note> $notes
         */
        $notes;

        $format = 'json'; //$this->getRequest()->getRequestFormat();

        $dm = $this->get('doctrine_mongodb')->getManager();
        $notes = $dm->getRepository('ItoolsInotesBundle:Note')->findBy(array("userId"=>$userId));

        if(!$notes){
            throw $this->createNotFoundException("No Notes found for user ". $userId ."!");
        }

        $result = array();
        $result['notes'] = array();
        $result['noteIds'] = array();
        $result['tags'] = array();
        foreach($notes->toArray() as $key => $note){
            $note->setLocalId($note->getId());
            $result['notes'][] = $note;
            $result['noteIds'][] = $key;
            $tags = $note->getTags();
            if(is_array($tags)){
                foreach($tags as $tag){
                    if(!array_key_exists($tag,$result['tags'])){
                        $result['tags'][$tag] = array();
                    }
                    $result['tags'][$tag][] = $key;
                }
            }
        }

        $serializer = $this->get("jms_serializer");
        $payload = $serializer->serialize($result, $format);
        return new Response($payload);
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
        $note->setCreationDate(new \DateTime());
        $note->setModificationDate(new \DateTime());

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
        $note->setLocalId($note->getId());


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

        //var_dump($newNote->getDrawing());exit
        $oldNote->setLocalId($newNote->getLocalId());
        $oldNote->setText($newNote->getText());
        $oldNote->setModificationDate(new \DateTime());
        $oldNote->setTags($newNote->getTags());
        $oldNote->setThumbnail($newNote->getThumbnail());
        $oldNote->setDrawing($newNote->getDrawing());
        $oldNote->setSticky($newNote->getSticky());

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
