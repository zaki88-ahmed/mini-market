<?php

namespace modules\Customers\Repositories;

use App\Http\Traits\ApiDesignTrait;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use modules\BaseRepository;
use modules\Customers\Interfaces\CustomerInterface;
use modules\Customers\Models\Customer;

class CustomerRepository extends BaseRepository implements CustomerInterface
{

    use ApiDesignTrait;

    /**
     * @OA\Post(
     * path="/api/customers/register",
     * summary="register",
     * description="register by name , email and password",
     * operationId="authLogin",
     * tags={"customers"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Fill your Data",
     *    @OA\JsonContent(
     *       required={"name", "email", "password"},
     *       @OA\Property(property="name", type="string", example="customer"),
     *       @OA\Property(property="email", type="string", format="email", example="customer@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="123456"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     *
     */

    public function register($request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:customers,email',
            'password'              => 'required|min:6',
        ]);
        if($validator->fails()) {
            return $this->ApiResponse(400, 'Validation Errors', $validator->errors());
        }
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $customer->assignRole('customer');
        return $this->ApiResponse(200, 'Please Verify Your Email');
    }


    /**
     * @OA\Post(
     * path="/api/customers/login",
     * summary="Sign in",
     * description="Login by email and password",
     * operationId="authLogin",
     * tags={"customers"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="customer@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="123456"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */


    public function login($request)
    {
        // TODO: Implement login() method.

        $data = ["email" => $request->email, "password" => $request->password];
        return $this->auth('customer', $data);
    }

    /**
     * @OA\Post(
     * path="/api/customers/logout",
     * summary="Logout",
     * description="Logout by email, password",
     * operationId="authLogout",
     * tags={"customers"},
     * security={ {"sanctum": {} }},
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */

    public function logout()
    {
        // TODO: Implement logout() method.
        $customer = auth('sanctum')->user();
        $customer->tokens()->where('id', $customer->currentAccessToken()->id)->delete();
        return $this->ApiResponse(200, 'Logged out');
    }


    /**
     * @OA\Post(
     *      path="/api/customers/update-password",
     *      operationId="update password",
     *      tags={"customers"},
     *      summary="Update Password",
     *      description="Update Password",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"old_password", "new_password"},
     *              @OA\Property(property="old_password", type="string", format="old_password", example="12345678"),
     *              @OA\Property(property="new_password", type="string", format="new_password", example="123456789"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password update successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function updatePassword($request)
    {
        // TODO: Implement updatePassword() method.

        Customer::find(auth('sanctum')->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
        return $this->apiResponse(200, 'Password updated successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/customers",
     *      operationId="get all customers",
     *      tags={"customers"},
     *      summary="Get list of customers",
     *      description="Returns list of customers",
     *     security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="All customers",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function allCustomers()
    {
        // TODO: Implement allVendors() method.
        $cusstomers = Customer::orderBy('id', 'DESC')->get();
        return $this->ApiResponse(200, 'All Customers', null, $cusstomers);
    }


    /**
     * @OA\Get(
     *      path="/api/customers/show",
     *      operationId="show specific Customer",
     *      tags={"customers"},
     *      summary="show specific customer",
     *      description="show specific customer",
     *     security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="customer details",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function customerDetails()
    {
        // TODO: Implement vendorDetails() method.
        $customer = auth('sanctum')->user();

        return $this->ApiResponse(200, 'Customer details', null, $customer);
    }

    /**
     * @OA\Post(
     *      path="/api/customers/edit",
     *      operationId="update customers",
     *      tags={"customers"},
     *      summary="customers",
     *      description="Edit customer",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass vendor credentials",
     *          @OA\JsonContent(
     *              required={"name", "email", "password"},
     *              @OA\Property(property="name", type="string",  example="customer"),
     *              @OA\Property(property="email", type="string", format="email", example="customer@gmail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="123456"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Customer update successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function updateCustomer($request)
    {
        // TODO: Implement updateVendor() method.

        $customer = auth('sanctum')->user();
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $this->apiResponse(200, 'Customer updated successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/customers/delete",
     *      operationId="delete specific customer",
     *      tags={"customers"},
     *      summary="Soft delete customer",
     *      description="Soft delete customer",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"customer_id"},
     *              @OA\Property(property="customer_id", type="integer", format="customer_id", example="1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Customer deleted successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function softDeleteCustomer($request)
    {
        // TODO: Implement softDeleteVendor() method.
        $customer = Customer::find($request->customer_id);
        if (is_null($customer)) {
            return $this->ApiResponse(400, 'No Customer Found');
        }
        $customer->delete();
        return $this->apiResponse(200,'Customer deleted successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/customers/restore",
     *      operationId="restore specific customer",
     *      tags={"customers"},
     *      summary="Restore delete customer",
     *      description="restore vendor",
     *     security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass customer credentials",
     *          @OA\JsonContent(
     *              required={"vendor_id"},
     *              @OA\Property(property="customer_id", type="integer", format="_id", example="1"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Customer restored successfully",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *        @OA\Response(
     *          response=400,
     *          description="Validation Error"
     *      )
     *     )
     */

    public function restoreCustomer($request)
    {

        // TODO: Implement restoreVendor() method.
        $customer = Customer::withTrashed()->find($request->customer_id);

        if (!is_null($customer->deleted_at)) {
            $customer->restore();
            return $this->ApiResponse(200,'Customer restored successfully');
        }
        return $this->ApiResponse(200,'Customer already restored');
    }


    public function verify($request, $id)
    {

        $customer = Customer::find($id);
        $customer->email_verified_at = Carbon::now();
        $customer->save();

        return $this->ApiResponse(200, 'You Are Signed In');

        }



}
