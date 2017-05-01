<?php namespace Bishopm\Connexion\Repositories;

use Bishopm\Connexion\Repositories\EloquentBaseRepository;

class PaymentsRepository extends EloquentBaseRepository
{   

	public function byPG($pg)
    {
        return $this->model->where('pgnumber',$pg)->orderBy('paymentdate')->get();
    }

}
