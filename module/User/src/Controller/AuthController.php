<?php
namespace User\Controller;

use User\Form\SignupForm;
use User\Form\LoginForm;
use User\Model\User;
use User\Service\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Service\AuthAdapter;
use Zend\Authentication\AuthenticationService;

class AuthController extends AbstractActionController
{
  private $table;
  public function __construct(UserTable $table)
  {
    $this->table = $table;
  }
  public function loginAction()
  {
    $auth = new AuthenticationService();
    if ($auth->hasIdentity()) {
      return $this->redirect()->toRoute('home');
    }
    $form = new LoginForm();
    $request = $this->getRequest();
    if (!$request->isPost()) {
      return ['form' => $form];
    }
    $form->setData($request->getPost());
    if (!$form->isValid()) {
      return ['form' => $form];
    }

    $authAdapter = new AuthAdapter($request->getPost()['username'], $request->getPost()['password'], $this->table);
    $result = $auth->authenticate($authAdapter);
    if (!$result->isValid()) {
      return [
        'form' => $form,
        'errors' => $result->getMessages(),
      ];
    }

    return $this->redirect()->toRoute('home');
  }
  public function signupAction()
  {
    $form = new SignupForm($this->table);
    $request = $this->getRequest();
    if (!$request->isPost()) {
      return ['form' => $form];
    }
    $form->setData($request->getPost());

    if (!$form->isValid()) {
      return ['form' => $form];
    }
    $user = new User();
    $data = $form->getData();
    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
    $user->exchangeArray($data);
    $this->table->saveUser($user);
    $view = new ViewModel();
    $view->setTemplate('user/auth/success.phtml');
    return $view;
  }
  public function logoutAction()
  {
    $auth = new AuthenticationService();
    $auth->clearIdentity();
    return $this->redirect()->toRoute('home');
  }
}
?>
