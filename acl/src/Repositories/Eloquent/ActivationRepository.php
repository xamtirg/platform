<?php

namespace Xamtirg\ACL\Repositories\Eloquent;

use Xamtirg\ACL\Models\Activation;
use Xamtirg\ACL\Models\User;
use Xamtirg\ACL\Repositories\Interfaces\ActivationInterface;
use Xamtirg\Support\Repositories\Eloquent\RepositoriesAbstract;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class ActivationRepository extends RepositoriesAbstract implements ActivationInterface
{
    /**
     * The activation expiration time, in seconds.
     */
    protected int $expires = 259200;

    /**
     * {@inheritDoc}
     */
    public function createUser(User $user)
    {
        $activation = $this->model;

        $code = $this->generateActivationCode();

        $activation->fill(compact('code'));

        $activation->user_id = $user->getKey();

        $activation->save();

        $this->resetModel();

        return $activation;
    }

    /**
     * {@inheritDoc}
     */
    public function exists(User $user, $code = null)
    {
        $expires = $this->expires();

        /**
         * @var Builder $activation
         */
        $activation = $this
            ->model
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('completed', false)
            ->where('created_at', '>', $expires);

        if ($code) {
            $activation->where('code', $code);
        }

        $this->resetModel();

        return $activation->first() ?: false;
    }

    /**
     * {@inheritDoc}
     */
    public function complete(User $user, $code): bool
    {
        $expires = $this->expires();

        /**
         * @var Activation $activation
         */
        $activation = $this
            ->model
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('code', $code)
            ->where('completed', false)
            ->where('created_at', '>', $expires)
            ->first();

        if ($activation === null) {
            return false;
        }

        $activation->fill([
            'completed' => true,
            'completed_at' => Carbon::now(),
        ]);

        $activation->save();

        $this->resetModel();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function completed(User $user)
    {
        $activation = $this
            ->model
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('completed', true)
            ->first();

        $this->resetModel();

        return $activation ?: false;
    }

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    public function remove(User $user): ?bool
    {
        /**
         * @var Activation $activation
         */
        $activation = $this->completed($user);

        if (! $activation) {
            return false;
        }

        $this->resetModel();

        return $activation->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function removeExpired()
    {
        $expires = $this->expires();

        return $this
            ->model
            ->newQuery()
            ->where('completed', false)
            ->where('created_at', '<', $expires)
            ->delete();
    }

    /**
     * Returns the expiration date.
     *
     * @return Carbon
     */
    protected function expires(): Carbon
    {
        return Carbon::now()->subSeconds($this->expires);
    }

    /**
     * Return a random string for an activation code.
     *
     * @return string
     */
    protected function generateActivationCode(): string
    {
        return Str::random(32);
    }
}
