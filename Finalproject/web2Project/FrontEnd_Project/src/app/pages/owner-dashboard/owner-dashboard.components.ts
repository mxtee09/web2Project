// src/app/pages/owner-dashboard/owner-dashboard.component.ts
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { DeliveryService } from '../../models/delivery.service';
import { Customer, Order, RiderJob } from '../../models/delivery.model';
import { Constants } from '../../config/constants';

@Component({
  selector: 'app-owner-dashboard',
  standalone: true,
  imports: [CommonModule, FormsModule],
  template: `
    <div class="max-w-7xl mx-auto p-4 grid grid-cols-1 lg:grid-cols-12 gap-6">

      @if (toastMessage) {
        <div class="lg:col-span-12 bg-emerald-600 text-white px-4 py-2.5 rounded-xl font-semibold text-sm shadow">
          ✅ {{ toastMessage }}
        </div>
      }

      <!-- คอลัมน์ซ้าย: ฟอร์มรับออเดอร์ลูกค้า -->
      <div class="lg:col-span-4 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
          <h2 class="text-base font-bold text-slate-900 mb-3">
            📝 รับออเดอร์ข้าวกล่อง (10:00 - 11:30 น.)
          </h2>

          <div class="mb-4">
            <label class="block text-xs font-bold text-slate-600 mb-1">
              🔍 ค้นหาลูกค้าเก่า (ใส่เบอร์โทร หรือ ชื่อ)
            </label>
            <input
              type="text"
              [(ngModel)]="searchPhoneOrName"
              (input)="onSearchCustomer()"
              placeholder="พิมพ์เบอร์โทร เช่น 0801111111..."
              class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none"
            />
            @if (selectedOldCustomer) {
              <div class="mt-2 p-2.5 bg-emerald-50 border border-emerald-300 rounded-xl text-xs text-emerald-900">
                🎉 <b>พบลูกค้าเก่า:</b> คุณ {{ selectedOldCustomer.firstname }} {{ selectedOldCustomer.lastname }}
                ({{ selectedOldCustomer.phone }})
              </div>
            }
          </div>

          <div class="space-y-3">
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="block text-xs text-slate-600 mb-1">ชื่อลูกค้า *</label>
                <input
                  type="text"
                  [(ngModel)]="customerForm.firstname"
                  [readonly]="!!selectedOldCustomer"
                  placeholder="ชื่อ"
                  class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-sm bg-slate-50"
                />
              </div>
              <div>
                <label class="block text-xs text-slate-600 mb-1">นามสกุล</label>
                <input
                  type="text"
                  [(ngModel)]="customerForm.lastname"
                  [readonly]="!!selectedOldCustomer"
                  placeholder="นามสกุล"
                  class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-sm bg-slate-50"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs text-slate-600 mb-1">เบอร์โทรศัพท์ *</label>
              <input
                type="text"
                [(ngModel)]="customerForm.phone"
                [readonly]="!!selectedOldCustomer"
                placeholder="08X-XXX-XXXX"
                class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-sm bg-slate-50"
              />
            </div>

            <div>
              <div class="flex items-center justify-between mb-1">
                <label class="block text-xs text-slate-600">พิกัดบ้านลูกค้า (Lat, Lng)</label>
                @if (!selectedOldCustomer) {
                  <button
                    type="button"
                    (click)="randomizeCustomerCoords()"
                    class="text-[11px] text-indigo-600 hover:underline font-semibold">
                    🎲 สุ่มพิกัดรอบร้าน
                  </button>
                }
              </div>
              <div class="grid grid-cols-2 gap-2">
                <input
                  type="number"
                  step="0.0001"
                  [(ngModel)]="customerForm.lat"
                  [readonly]="!!selectedOldCustomer"
                  class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-sm bg-slate-50"
                />
                <input
                  type="number"
                  step="0.0001"
                  [(ngModel)]="customerForm.lng"
                  [readonly]="!!selectedOldCustomer"
                  class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-sm bg-slate-50"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1">
                🍱 จำนวนกล่องที่สั่ง (ไม่เกิน 3 กล่อง/รายการ)
              </label>
              <div class="grid grid-cols-3 gap-2">
                @for (qty of [1, 2, 3]; track qty) {
                  <button
                    type="button"
                    (click)="orderQuantity = qty"
                    [class]="orderQuantity === qty
                      ? 'bg-amber-500 text-slate-950 font-bold py-2 rounded-lg border-2 border-amber-600'
                      : 'bg-slate-100 text-slate-700 py-2 rounded-lg border border-slate-300'">
                    {{ qty }} กล่อง
                  </button>
                }
              </div>
            </div>

            <button
              (click)="saveOrder()"
              [disabled]="isLoading"
              class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 rounded-xl shadow transition">
              ➕ บันทึกออเดอร์
            </button>
          </div>
        </div>

        <!-- รายการออเดอร์ทั้งหมด -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-bold text-slate-800">
              📦 ออเดอร์วันนี้ ({{ orders.length }} รายการ / {{ totalBoxes }} กล่อง)
            </h3>
            <div class="flex gap-1.5">
              <button
                (click)="onMockOrders()"
                class="text-xs bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold px-2.5 py-1.5 rounded-lg border border-indigo-200">
                🎲 จำลอง 25 ออเดอร์
              </button>
              <button
                (click)="onClearAllOrders()"
                class="text-xs bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold px-2.5 py-1.5 rounded-lg border border-rose-200">
                🗑️ ล้างทั้งหมด
              </button>
            </div>
          </div>

          <div class="max-h-72 overflow-y-auto divide-y divide-slate-100">
            @for (item of orders; track item.id) {
              <div class="py-2.5 flex items-center justify-between text-xs">
                <div>
                  <span class="font-bold text-slate-800">#{{ item.id }} คุณ {{ item.firstname }} {{ item.lastname }}</span>
                  <span class="ml-2 bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full">
                    {{ item.quantity }} กล่อง
                  </span>
                </div>
                <button
                  (click)="onDeleteOrder(item.id)"
                  class="text-rose-500 hover:text-rose-700 font-bold px-2">
                  ลบ
                </button>
              </div>
            } @empty {
              <div class="py-8 text-center text-slate-400 text-xs">
                ยังไม่มีรายการสั่งซื้อ กดปุ่ม <b>"🎲 จำลอง 25 ออเดอร์"</b> ด้านบนได้เลยครับ
              </div>
            }
          </div>
        </div>
      </div>

      <!-- คอลัมน์ขวา: ปุ่มกดจัดเส้นทาง + กระดานแสดงเส้นทางไรเดอร์แยกสี -->
      <div class="lg:col-span-8 space-y-6">
        <div class="bg-slate-900 text-white rounded-2xl p-5 shadow-lg flex flex-wrap items-center justify-between gap-4">
          <div>
            <span class="inline-block bg-amber-400 text-slate-950 text-xs font-extrabold px-2.5 py-0.5 rounded-full mb-1">
              ⏰ 11:30 น. อาหารเสร็จพร้อมส่ง!
            </span>
            <h2 class="text-lg md:text-xl font-bold">
              กดปุ่มเดียว ระบบจัดเส้นทางและแบ่งงานไรเดอร์ให้อัตโนมัติ
            </h2>
            <p class="text-xs text-slate-300 mt-0.5">
              ประหยัดค่าน้ำมัน • ไม่วิ่งไขว้ทับเส้นทาง • ส่งถึงมือก่อน 12:30 น. ทุกเจ้า
            </p>
          </div>

          <button
            (click)="onDispatchRoutes()"
            class="bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-base px-6 py-3.5 rounded-xl shadow-lg transition transform active:scale-95">
            🚀 จัดเส้นทาง (กดปุ่มเดียว)
          </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="bg-white p-3.5 rounded-xl border border-slate-200">
            <div class="text-xs text-slate-500">ออเดอร์ทั้งหมด</div>
            <div class="text-xl font-extrabold text-slate-900">{{ orders.length }} รายการ</div>
            <div class="text-[11px] text-slate-400">รวม {{ totalBoxes }} กล่อง</div>
          </div>
          <div class="bg-white p-3.5 rounded-xl border border-slate-200">
            <div class="text-xs text-slate-500">จำนวนไรเดอร์ที่ใช้</div>
            <div class="text-xl font-extrabold text-indigo-600">{{ riderJobs.length }} คัน</div>
            <div class="text-[11px] text-slate-400">คันละไม่เกิน 10 กล่อง</div>
          </div>
          <div class="bg-white p-3.5 rounded-xl border border-slate-200">
            <div class="text-xs text-slate-500">ส่งถึงมือลูกค้า</div>
            <div class="text-xl font-extrabold text-emerald-600">ทัน 12:30 น.</div>
            <div class="text-[11px] text-emerald-600 font-bold">✓ ภายใน 1 ชั่วโมง</div>
          </div>
          <div class="bg-white p-3.5 rounded-xl border border-slate-200">
            <div class="text-xs text-slate-500">เซฟเงินค่าปรับส่งเลท</div>
            <div class="text-xl font-extrabold text-amber-600">{{ orders.length * 20 }} บาท</div>
            <div class="text-[11px] text-slate-400">ไม่ต้องเสีย 20 บ./ออเดอร์</div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
          <h3 class="font-bold text-base text-slate-900 pb-3 border-b border-slate-100">
            🚦 กระดานแสดงเส้นทางวิ่งของไรเดอร์แต่ละคัน (แยกตามสี)
          </h3>

          @if (riderJobs.length === 0) {
            <div class="py-12 text-center space-y-2">
              <div class="text-4xl">🛵</div>
              <div class="font-bold text-slate-700">ยังไม่ได้คำนวณเส้นทาง</div>
              <p class="text-xs text-slate-500">
                กดปุ่ม <b>"🚀 จัดเส้นทาง (กดปุ่มเดียว)"</b> ด้านบน เพื่อแบ่งงานให้ไรเดอร์แต่ละคัน
              </p>
            </div>
          } @else {
            <div class="mt-4 space-y-5">
              @for (job of riderJobs; track job.riderId) {
                <div class="rounded-2xl border-2 p-4 bg-slate-50/60" [style.borderColor]="job.routeColor">
                  <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                    <div class="flex items-center gap-2">
                      <span class="px-3 py-1 rounded-lg text-white font-extrabold text-sm" [style.backgroundColor]="job.routeColor">
                        {{ job.riderName }}
                      </span>
                      <span class="text-xs font-bold text-slate-700 bg-white px-2.5 py-1 rounded-lg border">
                        🍱 หยิบ {{ job.totalBoxes }} / 10 กล่อง
                      </span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-slate-600">
                      <span>ระยะรวม: <b>{{ job.totalDistanceKm }} กม.</b></span>
                      <span>เวลารวม: <b>{{ job.totalMinutes }} นาที</b></span>
                      <button
                        (click)="goToRiderMobile(job.riderId)"
                        class="bg-slate-900 hover:bg-slate-800 text-white font-bold px-3 py-1.5 rounded-lg">
                        📱 ดูใบงานไรเดอร์คนนี้
                      </button>
                    </div>
                  </div>

                  <div class="relative pl-4 border-l-4 space-y-2 my-2" [style.borderColor]="job.routeColor">
                    @for (stop of job.stops; track stop.step) {
                      <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                        <div>
                          <b [style.color]="job.routeColor">จุดที่ {{ stop.step }}:</b>
                          ส่งบ้านคุณ {{ stop.order.firstname }} {{ stop.order.lastname }}
                          <span class="ml-1 font-bold text-amber-700">({{ stop.order.quantity }} กล่อง)</span>
                          <span class="text-slate-400 ml-2">ห่าง {{ stop.distanceKm }} กม.</span>
                        </div>
                        <span class="font-bold text-emerald-700">ถึง ~{{ stop.arrivalTimeText }}</span>
                      </div>
                    }
                    <div class="text-xs text-slate-600 font-semibold pt-1">
                      ↩️ ส่งครบแล้วขับกลับร้าน (ระยะทางขากลับ {{ job.returnDistanceKm }} กม.)
                    </div>
                  </div>
                </div>
              }
            </div>
          }
        </div>
      </div>
    </div>
  `
})
export class OwnerDashboardComponent implements OnInit {
  public customers: Customer[] = [];
  public orders: Order[] = [];
  public riderJobs: RiderJob[] = [];

  public searchPhoneOrName: string = '';
  public selectedOldCustomer: Customer | null = null;
  public customerForm: Customer = {
    firstname: '',
    lastname: '',
    phone: '',
    lat: 13.7563,
    lng: 100.5018
  };
  public orderQuantity: number = 1;
  public isLoading: boolean = false;
  public toastMessage: string = '';

  constructor(
    private deliveryService: DeliveryService,
    private router: Router
  ) {}

  async ngOnInit(): Promise<void> {
    await this.loadDataAsync();
    this.riderJobs = this.deliveryService.sharedRiderJobs;
  }

  public async loadDataAsync(): Promise<void> {
    try {
      this.isLoading = true;
      this.customers = await this.deliveryService.getCustomers();
      this.orders = await this.deliveryService.getOrders();
    } finally {
      this.isLoading = false;
    }
  }

  public onSearchCustomer(): void {
    const keyword = this.searchPhoneOrName.trim().toLowerCase();
    if (!keyword) {
      this.selectedOldCustomer = null;
      return;
    }
    const found = this.customers.find(
      (c) =>
        c.phone.includes(keyword) ||
        c.firstname.toLowerCase().includes(keyword) ||
        c.lastname.toLowerCase().includes(keyword)
    );
    if (found) {
      this.selectedOldCustomer = found;
      this.customerForm = { ...found };
    } else {
      this.selectedOldCustomer = null;
      this.customerForm.phone = this.searchPhoneOrName.trim();
    }
  }

  public randomizeCustomerCoords(): void {
    this.customerForm.lat = Number((Constants.SHOP_LAT + (Math.random() - 0.5) * 0.04).toFixed(4));
    this.customerForm.lng = Number((Constants.SHOP_LNG + (Math.random() - 0.5) * 0.04).toFixed(4));
  }

  public async saveOrder(): Promise<void> {
    try {
      this.isLoading = true;
      if (this.selectedOldCustomer && this.selectedOldCustomer.id) {
        await this.deliveryService.createOrder(this.selectedOldCustomer.id, this.orderQuantity);
        this.showNotification(`เพิ่มออเดอร์ให้คุณ ${this.selectedOldCustomer.firstname} สำเร็จ!`);
      } else {
        if (!this.customerForm.firstname || !this.customerForm.phone) {
          alert('กรุณากรอกชื่อและเบอร์โทรลูกค้าให้ครบถ้วนครับ');
          return;
        }
        const createdCust = await this.deliveryService.createCustomer({
          firstname: this.customerForm.firstname,
          lastname: this.customerForm.lastname || '-',
          phone: this.customerForm.phone,
          lat: Number(this.customerForm.lat),
          lng: Number(this.customerForm.lng)
        });
        if (createdCust && createdCust.id) {
          await this.deliveryService.createOrder(createdCust.id, this.orderQuantity);
          this.showNotification(`เพิ่มลูกค้าใหม่และบันทึกออเดอร์สำเร็จ!`);
        }
      }
      this.searchPhoneOrName = '';
      this.selectedOldCustomer = null;
      await this.loadDataAsync();
    } finally {
      this.isLoading = false;
    }
  }

  public async onMockOrders(): Promise<void> {
    this.isLoading = true;
    await this.deliveryService.generateMockOrders();
    await this.loadDataAsync();
    this.showNotification('จำลองรายการสั่งซื้อ 25 รายการสำเร็จ!');
  }

  public async onClearAllOrders(): Promise<void> {
    if (!confirm('ยืนยันการล้างรายการสั่งซื้อทั้งหมด?')) return;
    this.isLoading = true;
    await this.deliveryService.clearAllOrders();
    this.riderJobs = [];
    this.deliveryService.sharedRiderJobs = [];
    await this.loadDataAsync();
    this.showNotification('ล้างรายการสั่งซื้อทั้งหมดเรียบร้อยแล้ว');
  }

  public async onDeleteOrder(id: number): Promise<void> {
    await this.deliveryService.deleteOrder(id);
    await this.loadDataAsync();
  }

  public onDispatchRoutes(): void {
    if (this.orders.length === 0) {
      alert('กรุณาเพิ่มออเดอร์ หรือกดปุ่ม "จำลอง 25 ออเดอร์" ก่อนจัดเส้นทางครับ');
      return;
    }
    this.riderJobs = this.deliveryService.calculateSmartRoutes(this.orders, this.customers);
    this.showNotification(`จัดเส้นทางสำเร็จ! แบ่งงานให้ไรเดอร์ ${this.riderJobs.length} คัน`);
  }

  public goToRiderMobile(riderId: number): void {
    this.router.navigate(['/rider', riderId]);
  }

  public get totalBoxes(): number {
    return this.orders.reduce((sum, item) => sum + Number(item.quantity), 0);
  }

  private showNotification(msg: string): void {
    this.toastMessage = msg;
    setTimeout(() => (this.toastMessage = ''), 4000);
  }
}