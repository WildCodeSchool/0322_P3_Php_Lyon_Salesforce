<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('ideaSearch')]
final class IdeaSearchComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $searchBar = null;

    public function __construct(
        public IdeaRepository $ideaRepository
    ) {
    }

    public function getIdeas(): array
    {
        /** @var User $user */
        $user = $this->getUser();
        $userId = $user->getId();

        if (empty($this->searchBar)) {
            return [];
        }

        return $this->ideaRepository->findBySearch($this->searchBar, $userId);
    }
}
