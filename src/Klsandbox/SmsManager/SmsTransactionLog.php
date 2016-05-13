<?php

namespace Klsandbox\SmsManager;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SmsTransactionLog
 *
 * @property integer $site_id
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $delta
 * @property string $note
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsTransactionLog whereSiteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsTransactionLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsTransactionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsTransactionLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsTransactionLog whereDelta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SmsTransactionLog whereNote($value)
 * @mixin \Eloquent
 */
class SmsTransactionLog extends Model {

    use \Klsandbox\SiteModel\SiteExtensions;

    protected $fillable = ['delta', 'note'];

    //
}
