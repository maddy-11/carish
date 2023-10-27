<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Invoice</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <style type="text/css">
    @page {
      size: auto;
      /* auto is the initial value */
      margin: 5mm;
    }

    table {
      font-size: 10px;
    }

    table tr td {
      vertical-align: top;
      padding-bottom: 3px;
    }

    table {
      border-collapse: collapse;
      font-size: 12px;
      border-spacing: 0px;
    }

    .invoicetable tr td,
    .invoicetable tr th {
      border: 1px solid black;
      padding: 4px 7px;
    }

    .main-table>tbody>tr>td {
      padding-right: 10px;
      padding-left: 10px;
    }

    .invoicetable tr.inv-total-tr td {
      border: none;
      padding: 10px 2px 5px;
    }

    .inv-total-td span {
      font-weight: bold;
      border-bottom: 2px solid #000;
      display: inline-block;
      padding: 0px 5px 2px;
    }
    * {
      font-family: Firefly Sung, DejaVu Sans, Verdana, Arial, sans-serif;
  }
  </style>
</head>
  @php
  $setting = App\GeneralSetting::whereNotNull('created_at')->first();
  $arr = explode("\r\n", @$setting->bank_detail);
  @endphp
  <body style="font-family: sans-serif;padding: 70px 70px 0px;">
    <table class="main-table" style="max-width: 970px;width: 100%;margin-left: auto;margin-right: auto;margin: 0px auto;">
      <tbody>
        <tr>
          <td width="30%">
            <table class="table" style="width: 100%">
              <tbody>
                <tr>
                  <td colspan="2">
                    <img src="{{ public_path('assets/img/invoice_logo.png') }}" width="150" style="margin-bottom: 20px;">
                  </td>
                  <td>
                    <p> {{ __('dashboardPayment.invoice_number') }} : <b>C{{@$account->id}}</b></p>
                    <p> {{ __('dashboardPayment.invoice_date') }} : <b>{{@$account->created_at->format('d/m/y')}}</b></p>
                    <p> {{ __('dashboardPayment.due_date') }} : <b>{{@$account->created_at->addDays(7)->format('d/m/y')}}</b></p>
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%;">
                    <p style="margin: 0px 0px 6px;">
                      {{ __('dashboardPayment.payer') }} : <b>{{(@$user->invoice_setting != null) ? @$user->invoice_setting->invoice_name : @$user->customer_company}}</b>
                    </p>
                    <p>{{ __('dashboardPayment.reg_no') }}: <b>{{@$user->customer_registeration !== null ? @$user->customer_registeration : 'N.A'}}</b></p>
                    <p>{{ __('dashboardPayment.Address') }} : {{@$user->invoice_setting->address !== null ? @$user->invoice_setting->address : @$user->customer_default_address}}</p>
                    <p>{{ __('dashboardPayment.contact_person') }} : {{(@$user->invoice_setting->contact_person != null) ? @$user->invoice_setting->contact_person : 'N.A'}}</p>
                    <p>{{ __('dashboardPayment.vat_no') }}: {{@$user->customer_vat !== null ? @$user->customer_vat : 'N.A'}}</p>
                  </td>
                </tr>
                <tr style="height: 40px;">
                  <td height="15px;"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td align="center" style="padding-top: 0px;">
            <table class="table invoicetable" style="width: 100%;border-color: black;text-align: left;">
              <thead align="left">
                <tr>
                  <th>{{ __('dashboardPayment.content') }}</th>
                  <th>{{ __('dashboardPayment.amount') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    {{ $account->get_front_invoice_detail($account->id) }}
                  </td>
                  <td>
                    <span>
                      €{{@$account->paid_amount != 0 ? @$account->paid_amount : (@$account->credit != 0 ? @$account->credit : @$account->debit)}}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <p>{{ __('dashboardPayment.status') }} : <b>{{@$account->status == 0  ? __('dashboardPayment.not_paid') : __('dashboardPayment.paid')  }}</b></p>
            <p>{{ __('dashboardPayment.note') }}: {{ __('dashboardPayment.please_mention') }} <b>{{ __('dashboardPayment.invoice_number') }} </b>{{ __('dashboardPayment.while_paying_this_invoice') }}</p>
          </td>
        </tr>
      </tbody>
    </table>
    <div style="position: fixed;bottom: 200px;padding: 0 70px;">
      <div style="border-top: 1px solid black;">
        <p>{{ __('dashboardPayment.the_invoice_was_automatically_created_by') }}: Carish OÜ</p>
        <table width="100%">
          <tr>
            <td width="50%">
              {{@$setting->business_name}}
            </td>
            <td>
              <b>{{ __('dashboardPayment.bank_accounts') }}</b>
            </td>
          </tr>
          <tr>
            <td>{{@$setting->website_link}}</td>
            <td>
              <span>{!! nl2br(e(@$arr[0])) !!}</b></span>
            </td>
          </tr>
          <tr>
            <td>{{ __('dashboardPayment.registry_number') }}: {{@$setting->registry_number}}</td>
            <td>
              <span>{{@$arr[1]}}</b></span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>
  </html>