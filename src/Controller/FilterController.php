<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\IdeaRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap5View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/filter', name: 'filter')]
class FilterController extends AbstractController
{
    #[Route('/show/sorted/{order}/{page<\d+>}', name: '_sorting')]
    public function sortIdea(IdeaRepository $ideaRepository, string $order, int $page = 1): Response
    {
        $sortOrder = ($order === 'desc') ? 'desc' : 'asc';

        if ($sortOrder === 'desc') {
            $ideas = $ideaRepository->getIdeasGlobal();
        } else {
            $ideas = $ideaRepository->getAscIdeasGlobal();
        }
        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideas),
            $page,
            6
        );

        $pagerfanta = new TwitterBootstrap5View();

        return $this->render('home/index.html.twig', [
            'ideas' => $ideas,
            'pagerfanta' => $pagerfanta,
            'currentOrder' => $order,
        ]);
    }

    #[Route('/show/sortedOffice/{order}/{page<\d+>}', name: '_sorting_off')]
    public function sortIdeaForOffice(IdeaRepository $ideaRepository, string $order, int $page = 1): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $officeId = $user->getWorkplace()->getId();

        $sortOrder = ($order === 'desc') ? 'desc' : 'asc';

        if ($sortOrder === 'desc') {
            $ideas = $ideaRepository->getIdeasByUserOffice($officeId);
        } else {
            $ideas = $ideaRepository->getAscIdeasByUserOffice($officeId);
        }
        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideas),
            $page,
            6
        );

        $pagerfanta = new TwitterBootstrap5View();

        return $this->render('idea/ideasByUserOffice.html.twig', [
            'ideas' => $ideas,
            'pagerfanta' => $pagerfanta,
            'currentOrder' => $order,
            'user' => $user,
        ]);
    }

    #[Route('/show/sortedDepartment/{order}/{page<\d+>}', name: '_sorting_dep')]
    public function sortIdeaForDepartment(IdeaRepository $ideaRepository, string $order, int $page = 1): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $officeId = $user->getWorkplace()->getId();
        $departmentName = $user->getDepartment();

        $sortOrder = ($order === 'desc') ? 'desc' : 'asc';

        if ($sortOrder === 'desc') {
            $ideas = $ideaRepository->getIdeasByUserDepartment($officeId, $departmentName);
        } else {
            $ideas = $ideaRepository->getAscIdeasByUserDepartment($officeId, $departmentName);
        }
        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideas),
            $page,
            6
        );

        $pagerfanta = new TwitterBootstrap5View();

        return $this->render('idea/ideasByUserDepartment.html.twig', [
            'ideas' => $ideas,
            'pagerfanta' => $pagerfanta,
            'currentOrder' => $order,
            'user' => $user,
        ]);
    }

    #[Route('/show/sortedByPopularity/supp/{page<\d+>}', name: '_sorting_supp')]
    public function sortIdeaBySupporters(IdeaRepository $ideaRepository, int $page = 1): Response
    {
        // sort ideas by their Supporters' number DESC
        $ideas = $ideaRepository->getSupportersSortIdea(false);

        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideaRepository->getSupportersSortIdea(false)),
            $page,
            6
        );

        $pagerfanta = new TwitterBootstrap5View();

        return $this->render('home/index.html.twig', [
            'ideas' => $ideas,
            'pagerfanta' => $pagerfanta,
            'currentOrder' => 'supp',
        ]);
    }

    #[Route('/show/sortedByPopularity/supp/office/{page<\d+>}', name: '_sorting_supp_off')]
    public function sortIdeaBySupportersForOffice(IdeaRepository $ideaRepository, int $page = 1): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $officeId = $user->getWorkplace()->getId();

        // sort ideas by their Supporters' number DESC for the office
        $ideas = $ideaRepository->getSupportersSortIdeaForOffice($officeId, false);

        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideas),
            $page,
            6
        );

        $pagerfanta = new TwitterBootstrap5View();

        return $this->render('idea/ideasByUserOffice.html.twig', [
            'ideas' => $ideas,
            'pagerfanta' => $pagerfanta,
            'currentOrder' => 'supp',
            'user' => $user,
        ]);
    }

    #[Route('/show/sortedByPopularity/supp/department/{page<\d+>}', name: '_sorting_supp_dep')]
    public function sortIdeaBySupportersForDepartment(IdeaRepository $ideaRepository, int $page = 1): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $officeId = $user->getWorkplace()->getId();
        $departmentName = $user->getDepartment();

        // sort ideas by their Supporters' number DESC for the department
        $ideas = $ideaRepository->getSupportersSortIdeaForDepartment($officeId, $departmentName, false);

        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideas),
            $page,
            6
        );

        $pagerfanta = new TwitterBootstrap5View();

        return $this->render('idea/ideasByUserDepartment.html.twig', [
            'ideas' => $ideas,
            'pagerfanta' => $pagerfanta,
            'currentOrder' => 'supp',
            'user' => $user,
        ]);
    }
}
