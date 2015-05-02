<?php

namespace XarismaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use XarismaBundle\Entity\Dictionary;
use XarismaBundle\Form\DictionaryType;

/**
 * Dictionary controller.
 *
 */
class DictionaryController extends Controller
{

    /**
     * Lists all Dictionary entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('XarismaBundle:Dictionary')->findAll();

        return $this->render('XarismaBundle:Dictionary:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Dictionary entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Dictionary();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dictionary_show', array('id' => $entity->getId())));
        }

        return $this->render('XarismaBundle:Dictionary:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Dictionary entity.
     *
     * @param Dictionary $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Dictionary $entity)
    {
        $form = $this->createForm(new DictionaryType(), $entity, array(
            'action' => $this->generateUrl('dictionary_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Dictionary entity.
     *
     */
    public function newAction()
    {
        $entity = new Dictionary();
        $form   = $this->createCreateForm($entity);

        return $this->render('XarismaBundle:Dictionary:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Dictionary entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XarismaBundle:Dictionary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dictionary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('XarismaBundle:Dictionary:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dictionary entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XarismaBundle:Dictionary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dictionary entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('XarismaBundle:Dictionary:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Dictionary entity.
    *
    * @param Dictionary $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Dictionary $entity)
    {
        $form = $this->createForm(new DictionaryType(), $entity, array(
            'action' => $this->generateUrl('dictionary_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Dictionary entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XarismaBundle:Dictionary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dictionary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dictionary_edit', array('id' => $id)));
        }

        return $this->render('XarismaBundle:Dictionary:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Dictionary entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('XarismaBundle:Dictionary')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dictionary entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dictionary'));
    }

    /**
     * Creates a form to delete a Dictionary entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dictionary_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
