<?php

namespace Klsandbox\SmsManager;

use Illuminate\Database\Eloquent\Model;
use App;

/**
 * App\Models\SmsBalance
 *
 * @property integer $site_id
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $balance
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsBalance whereSiteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsBalance whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsBalance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsBalance whereBalance($value)
 */
class SmsBalance extends Model {

    protected $fillable = [];

    //

    public function TopUp($count, $note) {
        SmsTransactionLog::create(['delta' => $count, 'note' => 'top up:' . $note]);
        $this->balance += $count;
        $this->save();
    }

    public function Spend($note) {
        if ($this->balance <= 1) {
            App::abort(500, 'Insufficient credits.');
        }

        SmsTransactionLog::create(['delta' => -1, 'note' => 'spend:' . $note]);
        $this->balance -= 1;
        $this->save();
    }

}
