<?php
/**
 * Created by PhpStorm.
 * User: Adilet
 * Date: 21.02.15
 * Time: 1:21
 */

namespace Application\Sonata\UserBundle\Controller;


//class TicketAdminController {
//
//}
use Info\NewsBundle\Entity\News;
use Info\NewsBundle\Entity\NewsHasGallery;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\Response;

//use Symfony\Component\HttpKernel\Exception\HttpException;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\Request;

//use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
//use Sonata\AdminBundle\Admin\BaseFieldDescription;
//echo '<meta charset="utf-8">';
class UserAdminController extends CRUDController
{
//    /**
//     * The related Admin class
//     *
//     * @var \Sonata\AdminBundle\Admin\AdminInterface
//     */
//    protected $admin;


    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters['admin'] = isset($parameters['admin']) ?
            $parameters['admin'] :
            $this->admin;
        $parameters['base_template'] = isset($parameters['base_template']) ?
            $parameters['base_template'] :
            $this->getBaseTemplate();
        $parameters['admin_pool'] = $this->get('sonata.admin.pool');

        return parent::render($view, $parameters, $response);
    }

    private function logModelManagerException($e)
    {
        $context = array('exception' => $e);
        if ($e->getPrevious()) {
            $context['previous_exception_message'] = $e->getPrevious()->getMessage();
        }
        $this->getLogger()->error($e->getMessage(), $context);
    }

    /**
     * Create action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction()
    {


        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();
        $object->setAuthor($this->getUser());

        $this->admin->setSubject($object);


        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);


        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }


                $object = $this->admin->create($object);
                $countNewsHasGallery = count($object->getNewsHasGalleries());
                for ($item = 0; $item < $countNewsHasGallery; $item++) {
                    $newsHasGallery = new NewsHasGallery();
                    $media = $object->getNewsHasGalleries()[$item]->getMedia();
                    $newsHasGallery->setMedia($media);
                    $newsHasGallery->setNews($object);

                    $result = $this->admin->create($newsHasGallery);

                }

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result' => 'ok',
                        'objectId' => $this->admin->getNormalizedIdentifier($object),
                    ));
                }

                $this->addFlash(
                    'sonata_flash_success',
                    $this->admin->trans(
                        'flash_create_success',
                        array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                        'SonataAdminBundle'
                    )
                );

                // redirect to edit mode
                return $this->redirectTo($object);

            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }


        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form' => $view,
            'object' => $object,
        ));
    }


    /**
     * Edit action.
     *
     * @param int|string|null $id
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function editAction($id = null)
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $em = $this->getDoctrine()->getManager();

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                $object = $this->admin->update($object);
                $countNewsHasGallery = count($object->getNewsHasGalleries());

                $news = $object;


                if ($countNewsHasGallery == null) {
                    $gallery_to_remove = $em->getRepository('InfoNewsBundle:NewsHasGallery')->findByNews($news);
                    foreach ($gallery_to_remove as $item) {
                        $em->remove($item);
                    }
                    $em->flush();
                }


                $gallery_to_remove = $em->getRepository('InfoNewsBundle:NewsHasGallery')->findByNews($news);
                foreach ($gallery_to_remove as $item1) {
                    $temp = 0;
                    if($item1->getMedia()==null){
                        $em->remove($item1);
                        $em->flush();
                        $countNewsHasGallery = count($news->getNewsHasGalleries());
                    }
                    foreach ($news->getNewsHasGalleries() as $gallery) {
//            for ($item = 0; $item < $countNewsHasGallery; $item++) {
//                    $gallery_to_remove = $em->getRepository('InfoNewsBundle:NewsHasGallery')->findByNews($news);
//                    dump($item1->getId(), $gallery->getId());
                        if ($item1->getId() == $gallery->getId()) {
                            $temp++;
                            continue;
                        }
                    }
                    if ($temp == 0) {
                        $em->remove($item1);
                        $em->flush();
                        continue;
                    }

                }
                for ($item = 0; $item < $countNewsHasGallery; $item++) {
                    if ($news->getNewsHasGalleries()[$item]->getNews() == null) {
                        $newsHasGallery = $em->getRepository('InfoNewsBundle:NewsHasGallery')->find($news->getNewsHasGalleries()[$item]->getId());
                        $newsHasGallery->setNews($news);
                        $em->persist($newsHasGallery);
                    }
                    $em->flush();
                }

//                die();
//                for ($item = 0; $item < $countNewsHasGallery; $item++) {
//                    if($object->getNewsHasGalleries()[$item]->getNews()==null){
//                        $newsHasGallery = $em->getRepository('InfoNewsBundle:NewsHasGallery')->find($object->getNewsHasGalleries()[$item]->getId());
//                        $newsHasGallery->setNews($object);
//                        $em->persist($newsHasGallery);
//                    }
//                    $em->flush();
//                }

                try {
                    $object = $this->admin->update($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_edit_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_edit_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form' => $view,
            'object' => $object,
        ));
    }

}