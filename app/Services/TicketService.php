<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function getAll($limit, $page, $keyword, $seat) {
        $data = Ticket::with(['showtime', 'user', 'seat'])
            ->where('showtime_id', 'LIKE', $keyword)
            ->where('seats_id', 'LIKE', $seat)
            ->offset(($page - 1)*10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i ++){
            $data[$i]['showtime'] = $data[$i]->showtime;
            $data[$i]['user'] = $data[$i]->user;
            $data[$i]['seat'] = $data[$i]->seat;
            unset($data[$i]['user_id']);
            unset($data[$i]['showtime_id']);
            unset($data[$i]['seats_id']);
        }
        return $data;
    }

    public function getByUserId() {

    }
}
