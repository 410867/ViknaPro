<?php

namespace App\Form;

use App\Service\AppImgManager;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ImageType extends FileType
{
    private SluggerInterface $slugger;
    private AppImgManager $appImgManager;

    public function __construct(AppImgManager $appImgManager, SluggerInterface $slugger, TranslatorInterface $translator = null)
    {
        parent::__construct($translator);
        $this->slugger = $slugger;
        $this->appImgManager = $appImgManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $originalData = null;
        $transform = function (null|string $data) use (&$originalData) {
            if (!$data) {
                return null;
            }
            $originalData = $data;
            return new File(
                $this->appImgManager->getFullPathFromPublicPath($data)
            );
        };

        $reverseTransform = function (null|UploadedFile $data) use (&$originalData)  {
            if (!$data) {
                return $originalData;
            }

            $fileName = $this->getFileNameWithVersion($data) . '.' . $data->getClientOriginalExtension();
            $data->move($this->appImgManager->getDir(), $fileName);

            return $this->appImgManager->getPublicPathFromFilename($fileName);
        };

        $builder->addModelTransformer(new CallbackTransformer($transform, $reverseTransform));
    }

    private function getFileNameWithVersion(UploadedFile $data): string
    {
        return $this->slugger->slug(
                pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME)
            ) . date('_Y-m-d_H-i-s');
    }

    public function getBlockPrefix(): string
    {
        return 'image';
    }
}
