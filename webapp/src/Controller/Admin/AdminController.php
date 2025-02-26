<?php

namespace App\Controller\Admin;

use App\Entity\Cinemas;
use App\Entity\Salles;
use App\Entity\Films;
use App\Entity\Seances;
use App\Entity\Avis;
use App\Entity\Tarifs;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class AdminController extends AbstractDashboardController
{
    public function index(): Response
    {
	    return $this->redirectToRoute('admin_user_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<h4 class="text-center"><img src="/images/logo_cinephoria_trans.png"><br>Administration</h4>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Retour au site', 'fa fa-home', '/');
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Cinemas', 'fas fa-building', Cinemas::class);
        yield MenuItem::linkToCrud('Salles', 'fas fa-couch', Salles::class);
        yield MenuItem::linkToCrud('Films', 'fas fa-film', Films::class);
        yield MenuItem::linkToCrud('Séances', 'fas fa-video', Seances::class);
        yield MenuItem::linkToCrud('Avis', 'fas fa-comment-dots', Avis::class);
        yield MenuItem::linkToCrud('Tarifs', 'fas fa-coins', Tarifs::class);
        yield MenuItem::linkToCrud('Réservations', 'fas fa-ticket', Tarifs::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    }

	public function configureUserMenu(UserInterface $user): UserMenu
	{
		return parent::configureUserMenu($user)
			// use the given $user object to get the user name
			->setName($user->getPrenom())

			// you can also pass an email address to use gravatar's service
			->setGravatarEmail($user->getEmail());

			// you can use any type of menu item, except submenus
			//->addMenuItems([
			//	MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
			//]);
	}

	public function configureAssets(): Assets
	{
		return Assets::new()
			->addCssFile('css/admin.css')
			->addJsFile('js/admin.js');
	}


}
