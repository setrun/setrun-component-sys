<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\services;

use setrun\sys\entities\manage\Domain;
use setrun\sys\forms\backend\DomainForm;
use setrun\sys\repositories\DomainRepository;

/**
 * Class PageManageService.
 */
class DomainService
{
    /**
     * @var DomainRepository
     */
    protected $repository;

    public function __construct(DomainRepository $domainRepository)
    {
        $this->repository = $domainRepository;
    }

    /**
     * Domain item create.
     * @param DomainForm $form
     * @return Domain
     */
    public function create(DomainForm $form): Domain
    {
        $domain = Domain::create(
            $form->name,
            $form->alias,
            $form->url

        );
        $this->repository->save($domain);
        return $domain;
    }

    /**
     * Domain item edit.
     * @param $id
     * @param DomainForm $form
     * @return void
     */
    public function edit($id, DomainForm $form): void
    {
        $domain = $this->repository->get($id);
        $domain->edit(
            $form->name,
            $form->alias,
            $form->url
        );
        $this->repository->save($domain);
    }

    /**
     * Domain item remove.
     * @param $id
     * @return void
     */
    public function remove($id): void
    {
        $domain = $this->repository->get($id);
        $this->repository->remove($domain);
    }
}