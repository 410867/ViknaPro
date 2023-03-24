<?php

namespace App\Form;

use App\Service\AppImgManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ImageMultipleType extends AbstractType
{
    private SluggerInterface $slugger;
    private AppImgManager $appImgManager;

    public function __construct(AppImgManager $appImgManager, SluggerInterface $slugger, TranslatorInterface $translator = null)
    {
        $this->slugger = $slugger;
        $this->appImgManager = $appImgManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', CollectionType::class, [
                'entry_type' => HiddenType::class,
                'label' => false,
                'allow_delete' => true
            ])
            ->add('uploadedImages', FileType::class, ['multiple' => true, 'label' => false]);

        $transform = function (null|array $images) {

            return [
                'images' => $images
            ];
        };

        $reverseTransform = function (null|array $images) {
            $result = [];
            if (!empty($images['images'])) {
                $result = $images['images'];
            }

            if (!empty($images['uploadedImages'])) {
                foreach ($images['uploadedImages'] as $img) {
                    $result[] = $this->getFileNameWithVersion($img);
                }
            }

            return $result;
        };

        $builder->addModelTransformer(new CallbackTransformer($transform, $reverseTransform));
    }

    private function getFileNameWithVersion(UploadedFile $data): string
    {
        $nameWithVersion = $this->slugger->slug(
                pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME)
            ) . date('_Y-m-d_H-i-s');

        $fileName = $nameWithVersion . '.' . $data->getClientOriginalExtension();
        $data->move($this->appImgManager->getDir(), $fileName);

        return $this->appImgManager->getPublicPathFromFilename($fileName);
    }

    public function getBlockPrefix(): string
    {
        return 'image_multiple';
    }
}
