<?php

namespace App\Http\Controllers;

use App\Models\MyNfcCard;
use Illuminate\Http\Request;

class MyNfcController extends Controller
{

    public function getMyNfcCard(Request $request,$id){
        $data = MyNfcCard::where("added_by",$id);
        return $data->get();
    }

    // Create a new NFC card
    public function create(Request $request)
    {
        // Check if a card with the same card_id exists
        $existingCard = MyNfcCard::where('card_id', $request->input('card_id'))->first();

        if ($existingCard) {
            // If a card with the same card_id exists, update its attributes
            $existingCard->update($request->all());
            return response()->json(['message' => 'NFC card updated successfully'], 200);
        } else {
            // If no card with the same card_id exists, create a new one
            $nfcCard = new MyNfcCard();
            $nfcCard->fill($request->all());
            $nfcCard->save();
            return response()->json(['message' => 'NFC card created successfully'], 201);
        }
    }

    // Read a single NFC card by ID
    public function read($id)
    {
        $nfcCard = MyNfcCard::find($id);

        if (!$nfcCard) {
            return response()->json(['message' => 'NFC card not found'], 404);
        }

        return response()->json($nfcCard, 200);
    }

    // Update an existing NFC card
    public function update(Request $request, $id)
    {
        $nfcCard = MyNfcCard::find($id);

        if (!$nfcCard) {
            return response()->json(['message' => 'NFC card not found'], 404);
        }

        $nfcCard->fill($request->all());
        $nfcCard->save();

        return response()->json(['message' => 'NFC card updated successfully'], 200);
    }

    // Delete an NFC card
    public function delete($id)
    {
        $nfcCard = MyNfcCard::find($id);

        if (!$nfcCard) {
            return response()->json(['message' => 'NFC card not found'], 404);
        }

        $nfcCard->delete();

        return response()->json(['message' => 'NFC card deleted successfully'], 200);
    }
}
