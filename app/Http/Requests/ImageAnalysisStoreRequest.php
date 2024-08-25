<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Support\Facades\Log;


    class ImageAnalysisStoreRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules(): array
        {
            return [
                'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'videoName'     => 'required|string|max:255',
                'timestamp'     => 'required',
                'username'      => 'required|string|max:255',
                'profile_name'  => 'required|string|max:255',
                'request_token' => 'nullable|string'
            ];
        }

        /**
         * Get the error messages for the defined validation rules.
         *
         * @return array
         */
        public function messages(): array
        {
            return [
                'image.required'        => 'The image field is required.',
                'image.mimes'           => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.image'           => 'The file must be an image.',
                'videoName.required'    => 'The video name field is required.',
                'videoName.string'      => 'The video name must be a string.',
                'videoName.max'         => 'The video name may not be greater than 255 characters.',
                'timestamp.required'    => 'The timestamp field is required.',
                'username.required'     => 'The username field is required.',
                'username.string'       => 'The username must be a string.',
                'username.max'          => 'The username may not be greater than 255 characters.',
                'profile_name.required' => 'The profile name field is required.',
                'profile_name.string'   => 'The profile name must be a string.',
                'profile_name.max'      => 'The profile name may not be greater than 255 characters.',
            ];
        }

        /**
         * Handle a failed validation attempt.
         *
         * @param Validator $validator
         *
         * @return void
         */
        protected function failedValidation(Validator $validator)
        {
            $errors = $validator->errors()->all();
            $errorCount = count($errors);
            $displayedErrors = array_slice($errors, 0, 1); // Display only the first error
            $additionalErrorCount = $errorCount - count($displayedErrors);

            $message = implode(' ', $displayedErrors);
            if ($additionalErrorCount > 0) {
                $message .= " (and $additionalErrorCount more error" . ($additionalErrorCount > 1 ? 's' : '') . ")";
            }

            $response = [
                'result'  => false,
                'status'  => 'failed',
                'message' => $message,
                'errors'  => $validator->errors()->toArray(),
            ];

            Log::error(json_encode($response));
            Log::error('Request data: ' . json_encode($this->all()));


            throw new HttpResponseException(response()->json(
                $response, 422
            ));
        }
    }
