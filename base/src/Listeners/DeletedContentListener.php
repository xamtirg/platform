<?php

namespace Xamtirg\Base\Listeners;

use Xamtirg\Base\Events\DeletedContentEvent;
use Xamtirg\Base\Repositories\Interfaces\MetaBoxInterface;
use Exception;

class DeletedContentListener
{
    protected MetaBoxInterface $metaBoxRepository;

    public function __construct(MetaBoxInterface $metaBoxRepository)
    {
        $this->metaBoxRepository = $metaBoxRepository;
    }

    public function handle(DeletedContentEvent $event): void
    {
        try {
            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, $event->screen, $event->request, $event->data);

            $this->metaBoxRepository->deleteBy([
                'reference_id' => $event->data->id,
                'reference_type' => get_class($event->data),
            ]);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
