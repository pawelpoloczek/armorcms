<?php
declare(strict_types=1);

namespace ArmorCMS\User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ArmorCMS\Shared\Trait\Blameable;
use ArmorCMS\Shared\Trait\Identifyable;
use ArmorCMS\Shared\Trait\SoftDeletable;
use ArmorCMS\Shared\Trait\Timestampable;
use ArmorCMS\User\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Identifyable;
    use SoftDeletable;
    use Timestampable;
    use Blameable;

    private const AVAILABLE_ROLES = [
        'ROLE_USER',
        'ROLE_ADMIN',
        'ROLE_ROOT',
    ];

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct(
        #[ORM\Column(type: UuidType::NAME)]
        private readonly Uuid $uuid,
        #[ORM\Column(length: 255, unique: true)]
        private readonly string $username,
        #[ORM\Column(length: 255, unique: true)]
        private string $email
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function addRole(string $role): void
    {
        if (
            !in_array($role, self::AVAILABLE_ROLES)
            || in_array($role, $this->roles, true)
        ) {
            return;
        }

        $this->roles[] = $role;
    }

    public function removeRole(string $role): void
    {
        if (!in_array($role, $this->roles, true)) {
            return;
        }

        $key = array_search($role, $this->roles, true);
        unset($this->roles[$key]);
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->uuid;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->roles, true)
            || in_array('ROLE_ROOT', $this->roles, true);
    }
}
