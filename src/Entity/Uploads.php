<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UploadsRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Uploads
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filePath;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Expenditure", inversedBy="uploads")
     */
    private $expenditure;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
        $this->fileName = $file->getClientOriginalName();
        $this->filePath = uniqid('uniq-', true).$file->getClientOriginalName();
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preAll()
    {
        $this->file->move(
            realpath('../public/uploads'),
            $this->filePath
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeAll(){
        $filesystem = new Filesystem();
        $filesystem->remove(realpath('../public/uploads/'.$this->filePath));
    }

    public function getExpenditure(): ?Expenditure
    {
        return $this->expenditure;
    }

    public function setExpenditure(?Expenditure $expenditure): self
    {
        $this->expenditure = $expenditure;

        return $this;
    }
}
