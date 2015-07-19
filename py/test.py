import arrow
import random
import time

from models import Carinfo, Carinfo2


def loop_add_info():
    for i in range(13363617,13364805):
        time.sleep(random.randint(1, 5))
        print i
        s = Carinfo2.get_one(Carinfo2.id == i)
        c = Carinfo.insert(passtime=s.passtime,
                           cltx_id=s.cltx_id,
                           cltx_hphm=s.cltx_hphm,
                           cltx_place=s.cltx_place,
                           cltx_dire=s.cltx_dire,
                           cltx_color=s.cltx_color,
                           cltx_lane=s.cltx_lane,
                           img_ip=s.img_ip,
                           img_disk=s.img_disk,
                           img_path=s.img_path,
                           hphm=s.hphm,
                           hpzl=s.hpzl,
                           csys=s.csys,
                           cllx=s.cllx,
                           kxd=s.kxd,
                           ppdm=s.ppdm,
                           ppdm2=s.ppdm2,
                           clpp=s.clpp).execute()

if __name__ == '__main__':
    loop_add_info()
