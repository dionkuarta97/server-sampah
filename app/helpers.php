<?php

function sukses($data, $code = 200)
{
  return response()->json([
    'status' => 'sukses',
    'data' => $data
  ], $code);
}


function gagal($errors, $code = 500)
{
  return response()->json([
    'status' => 'gagal',
    'errors' => $errors
  ], $code);
}
