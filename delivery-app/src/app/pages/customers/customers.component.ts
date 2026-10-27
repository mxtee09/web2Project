import { Component, OnInit, inject, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../../api.service';
import { Customer, Order } from '../../models';

@Component({
  selector: 'app-customers', standalone: true, imports: [FormsModule],
  templateUrl: './customers.component.html', styleUrl: './customers.component.css',
})
export class CustomersComponent implements OnInit {
  private api = inject(ApiService);
  customers = signal<Customer[]>([]);
  orders = signal<Order[]>([]);
  msg = signal('');
  keyword = '';
  form: Customer = this.empty();
  qty: Record<number, number> = {};

  ngOnInit() { this.load(); }
  empty(): Customer { return { firstname: '', lastname: '', phone: '', lat: 16.2466, lng: 103.2550 }; }
  private err = (e: any) => this.msg.set('ผิดพลาด: ' + (e.error?.error ?? e.message));

  load() {
    this.api.getCustomers().subscribe({ next: d => this.customers.set(d), error: this.err });
    this.api.getOrders().subscribe({ next: d => this.orders.set(d), error: this.err });
  }
  search() {
    const k = this.keyword.trim();
    if (!k) return this.load();
    if (/^\d+$/.test(k)) // เบอร์โทร: API ไม่มี endpoint ค้นเบอร์ จึงกรองฝั่งหน้าเว็บ
      this.api.getCustomers().subscribe(d => this.customers.set(d.filter(c => c.phone.includes(k))));
    else this.api.searchCustomers(k).subscribe({ next: d => this.customers.set(d), error: this.err });
  }
  save() {
    const f = this.form;
    const req = f.id ? this.api.updateCustomer(f.id, f) : this.api.addCustomer(f);
    req.subscribe({ next: () => { this.msg.set('บันทึกแล้ว'); this.form = this.empty(); this.load(); }, error: this.err });
  }
  edit(c: Customer) { this.form = { ...c }; window.scrollTo(0, 0); }
  remove(c: Customer) { if (confirm('ลบ ' + c.firstname + '?')) this.api.deleteCustomer(c.id!).subscribe({ next: () => this.load(), error: this.err }); }
  order(c: Customer) {
    this.api.addOrder(c.id!, this.qty[c.id!] || 1).subscribe({ next: () => { this.msg.set('เพิ่มออเดอร์แล้ว'); this.load(); }, error: this.err });
  }
  editOrder(o: Order) {
    const q = Number(prompt('จำนวนกล่อง (1-3)', String(o.quantity)));
    if (q > 0) this.api.updateOrder(o.id, q).subscribe({ next: () => this.load(), error: this.err });
  }
  removeOrder(o: Order) { this.api.deleteOrder(o.id).subscribe({ next: () => this.load(), error: this.err }); }
}
